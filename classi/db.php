<?php

class DatabaseHelper
{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connesione fallita al db");
        }
    }

    //PRIVATE FUNCTIONS

    public function newOrder($clientId)
    {
        $query = "INSERT INTO `ordine` (`id`, `id_cliente`) VALUES (NULL, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
    }
    private function checkProductQuantity($id, $quantity)
    {
        $stmt = $this->db->prepare("SELECT  quantita_disponibile
                                    FROM prodotto
                                    WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()["quantita_disponibile"] >= $quantity ? true : false;
    }

    private function getProductQuantity($id)
    {
        $stmt = $this->db->prepare("SELECT  quantita_disponibile
                                    FROM prodotto
                                    WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()["quantita_disponibile"];
    }

    private function checkAlreadyInOrder($productId, $orderId)
    {

        $query = "SELECT * FROM collo WHERE id_prodotto = ? AND id_ordine = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $productId, $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? true : false;
    }

    private function getColloQuantity($productId, $orderId)
    {

        $query = "SELECT quantita_prodotto FROM collo WHERE id_prodotto = ? AND id_ordine = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $productId, $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()["quantita_prodotto"];
    }
    private function setColloShipping($colloId, $shippingId)
    {
        $query = "UPDATE `collo` SET 
                    `id_spedizione` = ? 
                    WHERE `collo`.`id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $shippingId, $colloId);
        $stmt->execute();
    }
    private function checkOrderProducts($orderId)
    {
        //Check disponibilita di ogni collo
        foreach ($this->getCollosFromOrder($orderId) as $orderElement) {
            if (!$this->checkProductQuantity($orderElement["id"], $orderElement["quantita_prodotto"])) {
                //Esito negativo il seguente prodotto e esaurito
                return /*$orderElement["id"];*/ false;
            }
        }
        return true;
    }

    //dato un id prodotto ne aggiorna la quantita dal magazzino
    private function updateProdottoQuantity($idProdotto, $quantity)
    {
        $query = "UPDATE `prodotto` SET `quantita_disponibile` = ? WHERE `prodotto`.`id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $quantity, $idProdotto);
        $stmt->execute();
    }

    //sottrae dal magazzino le quantita dei prodotti ordinati
    private function decreaseOrderedProductQuantity($orderId)
    {
        $collos = $this->getCollosFromOrder($orderId);
        foreach ($collos as $collo) {
            $this->updateProdottoQuantity($collo["id"], $this->getProductQuantity($collo["id"]) - $collo["quantita_prodotto"]);
        }
    }

    private function getVendorsFromOrder($orderId)
    {
        $stmt = $this->db->prepare("SELECT prodotto.id_venditore as id
                                    FROM `collo`, prodotto 
                                    WHERE collo.id_ordine = ? 
                                    AND collo.id_prodotto = prodotto.id 
                                    GROUP BY prodotto.id_venditore");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $r[] = $row["id"];
        }
        return $r;
    }

    private function insertShipping($incasso, $vendorId, $clientId)
    {
        $query = "INSERT INTO `spedizione` (`id`, `data`, `stato`, `incasso`, `id_venditore`, `id_cliente`) 
        VALUES (NULL, ?, 'preparazione', ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $date = date('Y-m-d H:i:s');
        $stmt->bind_param("sdii", $date, $incasso, $vendorId, $clientId);
        $stmt->execute();
        return $this->db->insert_id;
    }

    private function newShipping($orderId, $clientId)
    {
        //risalgo ai venditori
        //Join collo-prodotto
        //raggruppo per venditore
        $vendorList = $this->getVendorsFromOrder($orderId);
        //per ogni venditore sommo incasso e creo spedizione
        foreach ($vendorList as $vendor) {
            $collos = $this->getCollosFromVendorOrder($vendor, $orderId);
            $incasso = 0;
            foreach ($collos as $collo) {
                $incasso += $collo["quantita_prodotto"] * $collo["prezzo"];
            }
            //nuova spedizione
            $shippingId = $this->insertShipping($incasso, $vendor, $clientId);
            foreach ($collos as $collo) {
                $this->setColloShipping($collo["id"], $shippingId);
            }
            //notifico il venditore dei suoi ordini
            $this->notifyVendor($clientId, $vendor);
        }
    }

    private function checkPaid($orderId)
    {
        $query = "SELECT * FROM pagamento WHERE id_ordine = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? true : false;
    }

    private function notifyVendor($clientId, $vendorId)
    {
        $query = "INSERT INTO `notifica_venditore` (`id`, `testo`, `data`, `id_venditore`) 
        VALUES (NULL, ? , ?, ?)";
        $stmt = $this->db->prepare($query);
        $date = date('Y-m-d H:i:s');
        $text = "Hai un nuovo ordine dal cliente " . strval($clientId);
        $stmt->bind_param("ssi", $text, $date, $vendorId);
        $stmt->execute();
    }

    private function notifyClient($shippingId)
    {
        $query = "SELECT spedizione.id_cliente, ordine.id as numero_ordine, prodotto.nome as nome_prodotto, venditore.nome as nome_venditore 
                FROM spedizione, collo, `ordine` , prodotto, venditore 
                WHERE spedizione.id = collo.id_spedizione 
                AND collo.id_ordine = ordine.id 
                AND spedizione.id = ? 
                AND collo.id_prodotto = prodotto.id 
                AND prodotto.id_venditore = venditore.id";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $shippingId);
        $stmt->execute();
        $result = $stmt->get_result();
        $prodotti = "";
        foreach ($result as $row) {
            $clientId = $row["id_cliente"];
            $numeroOrdine = $row["numero_ordine"];
            $prodotti .= $row["nome_prodotto"] . " ";
            $nomeVenditore = $row["nome_venditore"];
        }
        $query = "INSERT INTO `notifica_cliente` (`id`, `testo`, `data`, `id_cliente`) 
        VALUES (NULL, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $date = date('Y-m-d H:i:s');
        $text = "Il venditore " . $nomeVenditore . " ha spedito i seguenti prodotti: " . $prodotti . " appartenenti al tuo ordine " . strval($numeroOrdine);
        $stmt->bind_param("ssi", $text, $date, $clientId);
        $stmt->execute();
    }

    //PUBLIC FUNCTIONS

    //GET OR SHOW

    public function cechCardCvv($cardCode, $cvv)
    {
        $stmt = $this->db->prepare("SELECT cvv
        FROM `carta`
        WHERE codice = ?");
        $stmt->bind_param("i", $cardCode);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return password_verify($cvv, $result->fetch_assoc()['cvv']);
        }
        return false;
    }

    public function getCardsFromIdClient($idCliente)
    {
        $stmt = $this->db->prepare("SELECT *
                                    FROM `carta`
                                    WHERE id_cliente = ?");
        $stmt->bind_param("i", $idCliente);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getVendorName($vendorId)
    {
        $stmt = $this->db->prepare("SELECT nome FROM `venditore`WHERE id = ?");
        $stmt->bind_param("i", $vendorId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()["nome"];
    }

    public function getVendorContacts($vendorId)
    {
        $stmt = $this->db->prepare("SELECT email FROM `venditore`WHERE id = ?");
        $stmt->bind_param("s", $vendorId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()["email"];
    }

    public function getOrdersIdByClientId($clientId)
    {
        $stmt = $this->db->prepare("SELECT id 
                                    FROM `ordine` 
                                    WHERE id_cliente = ? ORDER BY id DESC");
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        $result = $stmt->get_result();
        $cat = [];
        foreach ($result as $order) {
            array_push($cat, $order["id"]);
        }
        return $cat;
    }

    public function getLastOrderIdByClientId($id)
    {
        $stmt = $this->db->prepare("SELECT id 
                                    FROM `ordine` 
                                    WHERE id_cliente = ?
                                    ORDER BY `ordine`.`id` 
                                    DESC LIMIT 1");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()["id"];
    }

    public function getCartProductsByClientId($clientId)
    {
        return $this->getCollosFromOrder($this->getLastOrderIdByClientId($clientId));
    }

    public function checkClientLogin($email, $password)
    {
        $stmt = $this->db->prepare("SELECT email, password FROM `cliente` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return password_verify($password, $result->fetch_assoc()['password']);
        }
        return false;
    }

    public function checkVendorLogin($email, $password)
    {
        $stmt = $this->db->prepare("SELECT email, password FROM `venditore` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return password_verify($password, $result->fetch_assoc()['password']);
        }
        return false;
    }

    public function getClientId($email)
    {
        $stmt = $this->db->prepare("SELECT id FROM `cliente` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['id'];
    }

    public function getVendorId($email)
    {
        $stmt = $this->db->prepare("SELECT id FROM `venditore` WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()['id'];
    }

    public function getCategories()
    {
        $stmt = $this->db->prepare("SELECT id, nome FROM `categoria`");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }
    public function getProductCategories($idProdotto)
    {
        $stmt = $this->db->prepare("SELECT * FROM appartenenza_categorie,categoria WHERE appartenenza_categorie.id_prodotto= ? AND appartenenza_categorie.id_categoria = categoria.id");
        $stmt->bind_param("i", $idProdotto);
        $stmt->execute();
        $result = $stmt->get_result();
        $result->fetch_all(MYSQLI_ASSOC);
        $cat = [];
        foreach ($result as $categoria) {
            array_push($cat, $categoria["id"]);
        }
        return $cat;
    }

    public function getNotifyFromVendor($vendorId)
    {
        $stmt = $this->db->prepare("SELECT * FROM `notifica_venditore` WHERE id_venditore  = ? ORDER BY id DESC");
        $stmt->bind_param("i", $vendorId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getNotifyFromClient($clientId)
    {
        $stmt = $this->db->prepare("SELECT * FROM `notifica_cliente` WHERE id_cliente  = ? ORDER BY id DESC");
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteNotifyFromClient($notifyId)
    {
        $stmt = $this->db->prepare("DELETE FROM `notifica_cliente` WHERE id = ?");
        $stmt->bind_param("i", $notifyId);
        $stmt->execute();
    }

    public function deleteNotifyFromVendor($notifyId)
    {
        $stmt = $this->db->prepare("DELETE FROM `notifica_venditore` WHERE id = ?");
        $stmt->bind_param("i", $notifyId);
        $stmt->execute();
    }

    public function getShippingsFromOrder($orderId)
    {
        $stmt = $this->db->prepare("SELECT id_spedizione as id
                                    FROM collo 
                                    WHERE id_ordine = ? 
                                    AND id_spedizione is not null
                                    group by id_spedizione");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        $result->fetch_all(MYSQLI_ASSOC);
        $cat = [];
        foreach ($result as $shipping) {
            array_push($cat, $shipping["id"]);
        }
        return $cat;
    }



    public function getProductsFromShipping($shippingId)
    {
        $stmt = $this->db->prepare("SELECT prodotto.id, 
                                    prodotto.nome, 
                                    prodotto.foto, 
                                    prodotto.prezzo, 
                                    collo.quantita_prodotto 
                                    FROM `spedizione`, prodotto,collo 
                                    WHERE spedizione.id = ? 
                                    AND collo.id_prodotto = prodotto.id 
                                    AND collo.id_spedizione = spedizione.id");
        $stmt->bind_param("i", $shippingId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getShippingStatus($shippingId)
    {
        $stmt = $this->db->prepare("SELECT stato
                                    FROM `spedizione`
                                    WHERE spedizione.id = ?");
        $stmt->bind_param("i", $shippingId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()["stato"];
    }

    public function getProgressShippingFromVendorId($vendorId)
    {
        $stmt = $this->db->prepare("SELECT spedizione.id as sid, incasso, data , stato , 
                                    ( SELECT COUNT(prodotto.id) FROM `spedizione`, prodotto, collo 
                                        WHERE spedizione.id = sid 
                                            AND collo.id_prodotto = prodotto.id 
                                            AND collo.id_spedizione = spedizione.id ) 
                                        AS n_prodotti 
                                    FROM `spedizione`, collo, prodotto 
                                    WHERE collo.id_prodotto = prodotto.id 
                                        AND collo.id_spedizione = spedizione.id 
                                        AND stato = 'preparazione' 
                                        AND prodotto.id_venditore = ? 
                                    GROUP BY sid DESC");
        $stmt->bind_param("i", $vendorId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getShippingFromId($shippingId)
    {
        $stmt = $this->db->prepare("SELECT *
                                    FROM `spedizione`
                                    WHERE id = ?");
        $stmt->bind_param("i", $shippingId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getDeliveredShippingFromVendorId($vendorId)
    {
        $stmt = $this->db->prepare("SELECT spedizione.id as sid, incasso, data , stato , 
                                        ( SELECT COUNT(prodotto.id) FROM `spedizione`, prodotto, collo 
                                        WHERE spedizione.id = sid 
                                        AND collo.id_prodotto = prodotto.id 
                                        AND collo.id_spedizione = spedizione.id ) 
                                        AS n_prodotti 
                                    FROM `spedizione`, collo, prodotto 
                                    WHERE collo.id_prodotto = prodotto.id 
                                        AND collo.id_spedizione = spedizione.id 
                                        AND stato = 'spedito' 
                                        AND prodotto.id_venditore = ? 
                                        GROUP BY sid DESC");
        $stmt->bind_param("i", $vendorId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function showProducts($n = 3)
    {
        $stmt = $this->db->prepare("SELECT  *  FROM prodotto WHERE visibile=1  LIMIT ?");
        $stmt->bind_param("i", $n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsByName($productName)
    {
        $stmt = $this->db->prepare("SELECT  *  FROM prodotto WHERE visibile=1 AND nome LIKE ? ");
        $productName = "%" . $productName . "%";
        $stmt->bind_param("s", $productName);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsNameByName($productName)
    {
        $stmt = $this->db->prepare("SELECT  id , nome  FROM prodotto WHERE visibile=1 AND nome LIKE ? ");
        $productName = "%" . $productName . "%";
        $stmt->bind_param("s", $productName);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getImgFromId($id)
    {
        $stmt = $this->db->prepare("SELECT  nome, foto  FROM prodotto  WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        return '<img class="img-fluid w-100" src="'  . UPLOAD_DIR . $row["foto"] . '" alt= "' . $row["nome"] .  '"  ';
    }

    public function getCategoriesFromId($id)
    {
        $stmt = $this->db->prepare("SELECT nome 
                                    FROM appartenenza_categorie, categoria 
                                    WHERE id_prodotto=? AND id_categoria = categoria.id");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $result->fetch_all(MYSQLI_ASSOC);
        $categorie = "";
        foreach ($result as $row) {
            $categorie .=  $row["nome"] . " ";
        }
        return $categorie;
    }

    public function getProductsFromCategories($categoryId)
    {
        $stmt = $this->db->prepare("SELECT  prodotto.id, prodotto.nome, prezzo, quantita_disponibile, visibile, foto, descrizione, id_venditore
                                    FROM prodotto, appartenenza_categorie, categoria 
                                    WHERE prodotto.visibile=1
                                    AND categoria.id = ?
                                    AND categoria.id = appartenenza_categorie.id_categoria
                                    AND prodotto.id = appartenenza_categorie.id_prodotto");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getVisibleProductsFromVendorId($vendorId)
    {
        $stmt = $this->db->prepare("SELECT *
                                    FROM `prodotto`
                                    WHERE prodotto.visibile=1
                                    AND id_venditore = ?");
        $stmt->bind_param("i", $vendorId);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsFromVendorId($id)
    {
        $stmt = $this->db->prepare("SELECT *
                                    FROM `prodotto`
                                    WHERE id_venditore = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductFromId($id)
    {
        $stmt = $this->db->prepare("SELECT  *
                                    FROM prodotto
                                    WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    //ritorna un array di array associativi dei colli di un ordine con valori:
    // id_prodotto, quantita_prodotto (ordinata nel collo)
    // prezzo (unitario del prodotto)
    // foto e id_venditore
    public function getCollosFromOrder($orderId)
    {
        $stmt = $this->db->prepare("SELECT collo.id_prodotto as id, 
                                    quantita_prodotto, 
                                    prodotto.nome, 
                                    prodotto.prezzo, 
                                    prodotto.foto, 
                                    prodotto.id_venditore 
                                    FROM `collo`, prodotto 
                                    WHERE id_ordine = ? 
                                    AND collo.id_prodotto = prodotto.id");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //passi idOrdine e prendi costo totale ordine
    public function getOrderCost($orderId)
    {
        $stmt = $this->db->prepare("SELECT SUM(prodotto.prezzo * collo.quantita_prodotto) 
                                    as costo 
                                    FROM `collo`, prodotto 
                                    WHERE prodotto.id = collo.id_prodotto 
                                    AND collo.id_ordine = ?");
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()["costo"];
    }

    public function getCollosFromVendorOrder($vendorId, $orderId)
    {
        $stmt = $this->db->prepare("SELECT collo.id,
                                    collo.id_prodotto as id_prodotto, 
                                    quantita_prodotto, 
                                    prodotto.nome, 
                                    prodotto.prezzo,
                                    prodotto.id_venditore
                                    FROM `collo`, prodotto 
                                    WHERE id_ordine = ? 
                                    AND prodotto.id_venditore = ?
                                    AND collo.id_prodotto = prodotto.id");
        $stmt->bind_param("ii", $orderId, $vendorId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    //UPDATE OR INSERT

    public function sendShipping($shippingId)
    {
        $query = "UPDATE `spedizione` SET `stato` = 'spedito' WHERE `spedizione`.`id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i",  $shippingId);
        $stmt->execute();
        $this->notifyClient($shippingId);
    }

    public function updateProductFromId($id, $nome, $prezzo, $qta, $visible, $foto, $desc)
    {
        $query = "UPDATE `prodotto` 
                    SET `nome` = ?, 
                    `prezzo` = ?,
                    `quantita_disponibile` = ?,
                    `visibile` = ?, 
                    `foto` = ?, 
                    `descrizione` = ? 
                    WHERE `prodotto`.`id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sdiissi", $nome, $prezzo, $qta, $visible, $foto, $desc, $id);
        $stmt->execute();
    }

    public function insertNewProduct($nome, $prezzo, $qta, $visible, $foto, $desc, $vendorId)
    {
        $query = "INSERT INTO `prodotto` 
        (`id`, `nome`, `prezzo`, `quantita_disponibile`, `visibile`, `foto`, `descrizione`, `id_venditore`) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sdiissi", $nome, $prezzo, $qta, $visible, $foto, $desc, $vendorId);
        $stmt->execute();
        return $this->db->insert_id;
    }

    //0 hidden, 1 visible
    public function setProductVisibilityFromId($id, $isVisible)
    {
        $query = "UPDATE `prodotto` SET `visibile` = ? WHERE `prodotto`.`id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $isVisible, $id);
        $stmt->execute();
    }

    public function updateColloQuantity($quantity, $orderId, $productId)
    {
        $query = "UPDATE `collo` 
                    SET `quantita_prodotto` = ? 
                    WHERE `collo`.`id_prodotto` = ? 
                    AND collo.id_ordine = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $quantity, $productId, $orderId);
        $stmt->execute();
    }

    public function deleteCollo($orderId, $productId)
    {
        $query = "DELETE FROM `collo` WHERE `collo`.`id_ordine` = ? AND collo.id_prodotto = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $orderId, $productId);
        $stmt->execute();
    }

    //Ritorna true se ordina il prodotto, false se non si puo ordinare
    public function orderProduct($id, $quantity, $idCliente)
    {
        if ($quantity <= 0) {
            return false;
        }
        $orderId = $this->getLastOrderIdByClientId($idCliente);
        if ($this->checkAlreadyInOrder($id, $orderId)) {
            $this->updateColloQuantity($quantity + $this->getColloQuantity($id, $orderId), $orderId, $id);
            return;
        }
        $query = "INSERT INTO `collo` (`id`, `quantita_prodotto`, `id_prodotto`, `id_spedizione`, `id_ordine`) VALUES (NULL, ? , ? , NULL, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $quantity, $id, $orderId);
        $stmt->execute();
    }

    //effettua un pagamento
    public function insertPayment($orderId, $orderCost, $cardCode)
    {
        $query = "INSERT INTO `pagamento` (`id`, `id_ordine`, `data`, `totale`, `codice_carta`) 
                    VALUES (NULL, ? , ? , ?, ?)";
        $stmt = $this->db->prepare($query);
        $date = date('Y-m-d H:i:s');
        $stmt->bind_param("isdi", $orderId, $date, $orderCost, $cardCode);
        return $stmt->execute();
    }

    //ritorna true se l'ordinazione è andata a buon fine false altrimenti
    public function startOrder($orderId, $cardCode, $clientId)
    {
        //controlla se ci sono le disponibilita dei prodotti in magazzino o se e gia stato ordinato (se esiste gia il pagamento)
        if (!$this->checkOrderProducts($orderId) || $this->checkPaid($orderId)) {
            return false;
        }
        //calcola il costo totale dell ordine
        $orderCost = $this->getOrderCost($orderId);
        //effettua nuovo pagamento
        if ($this->insertPayment($orderId, $orderCost, $cardCode)) {
            //elimina le quantita di prodotti ordinati dal magazzino
            $this->decreaseOrderedProductQuantity($orderId);
            //crea le spedizioni
            $this->newShipping($orderId, $clientId);
            //crea nuovo ordine
            $this->newOrder($clientId);
            return true;
        }
        return false;
    }

    public function deleteCard($cardCode)
    {
        $stmt = $this->db->prepare("DELETE FROM `carta` WHERE codice = ?");
        $stmt->bind_param("i", $cardCode);
        $stmt->execute();
    }

    public function addNewCard($cardCode, $date, $id, $cvv)
    {
        $stmt = $this->db->prepare("INSERT INTO `carta` (`codice`, cvv, `scadenza`, `id_cliente`) 
                                    VALUES (?, ? ,?, ?);");
        $cvv = password_hash($cvv, PASSWORD_DEFAULT);
        if (is_string($cvv)) {
            $stmt->bind_param("issi", $cardCode, $cvv, $date, $id);
            return $stmt->execute();
        }
        return false;
    }

    public function changeMailClient($mail, $clientId)
    {
        $stmt = $this->db->prepare("UPDATE `cliente` SET `email` = ? WHERE `cliente`.`id` = ?");
        $stmt->bind_param("si", $mail, $clientId);
        return $stmt->execute();
    }

    public function changePasswordClient($password, $clientId)
    {
        $stmt = $this->db->prepare("UPDATE `cliente` SET `password` = ? WHERE `cliente`.`id` = ?");
        $password = password_hash($password, PASSWORD_DEFAULT);
        if (is_string($password)) {
            $stmt->bind_param("si", $password, $clientId);
            return $stmt->execute();
        }
        return false;
    }

    public function changeMailVendor($mail, $vendorId)
    {
        $stmt = $this->db->prepare("UPDATE `venditore` SET `email` = ? WHERE `venditore`.`id` = ?");
        $stmt->bind_param("si", $mail, $vendorId);
        return $stmt->execute();
    }

    public function changePasswordVendor($password, $vendorId)
    {
        $stmt = $this->db->prepare("UPDATE `venditore` SET `password` = ? WHERE `venditore`.`id` = ?");
        $password = password_hash($password, PASSWORD_DEFAULT);
        if (is_string($password)) {
            $stmt->bind_param("si", $password, $vendorId);
            return $stmt->execute();
        }
        return false;
    }

    public function registerClient($clientEmail, $password, $cf)
    {
        $stmt = $this->db->prepare("INSERT INTO `cliente` (`id`, `email`, `password`, `CF`) 
        VALUES (NULL, ?, ?, ?)");
        $password = password_hash($password, PASSWORD_DEFAULT);
        if (is_string($password)) {
            $stmt->bind_param("sss", $clientEmail, $password, $cf);
            return $stmt->execute();
        }
        return false;
    }

    public function getCategoryName($categoryId)
    {
        $stmt = $this->db->prepare("SELECT nome FROM `categoria`WHERE id = ?");
        $stmt->bind_param("i", $categoryId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc()["nome"];
    }

    public function deleteAllCategories($prodId)
    {
        $stmt = $this->db->prepare("DELETE FROM `appartenenza_categorie` WHERE `id_prodotto` = ?");
        $stmt->bind_param("i", $prodId);
        return $stmt->execute();
    }

    public function addCategory($prodId)
    {
        $stmt = $this->db->prepare("DELETE FROM `appartenenza_categorie` WHERE `id_prodotto` = ?");
        $stmt->bind_param("i", $prodId);
        return $stmt->execute();
    }

    public function insertCategory($prodId, $categoryId)
    {
        $stmt = $this->db->prepare("INSERT INTO appartenenza_categorie (id_categoria, id_prodotto) VALUES (?, ?)");
        $stmt->bind_param("ii", $categoryId, $prodId);
        return $stmt->execute();
    }



    function manageCategory($prodId, $checkedCategories)
    {
        if ($this->deleteAllCategories($prodId) && !empty($checkedCategories)) {
            foreach ($checkedCategories as $categoryId) {
                $this->insertCategory($prodId, $categoryId);
            }
        }
    }

    public function newCategory($categoryName)
    {
        $query = "INSERT INTO `categoria` (`nome`) VALUES (?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
    }
}
