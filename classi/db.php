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

    public function showProducts($n = 3)
    {
        $stmt = $this->db->prepare("SELECT  *  FROM prodotto WHERE visibile=1  LIMIT ?");
        $stmt->bind_param("i", $n);
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
        return '<img src="'  . UPLOAD_DIR . $row["foto"] . '" alt= "' . $row["nome"] .  '" /> ';
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

    public function getProductsFromCategories($categoryName)
    {
        $stmt = $this->db->prepare("SELECT  prodotto.id, prodotto.nome, prezzo, quantita_disponibile, visibile, foto, descrizione, id_venditore
                                    FROM prodotto, appartenenza_categorie, categoria 
                                    WHERE prodotto.visibile=1
                                    AND categoria.nome = ?
                                    AND categoria.id = appartenenza_categorie.id_categoria
                                    AND prodotto.id = appartenenza_categorie.id_prodotto");
        $stmt->bind_param("s", $categoryName);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getProductsFromVendor($id)
    {
        $stmt = $this->db->prepare("SELECT  *
                                    FROM prodotto
                                    WHERE prodotto.visibile=1
                                    AND id_venditore = ?");
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

    public function updateProductFromId($id, $nome, $prezzo, $qta, $visible, $foto, $desc)
    {
        $query = "UPDATE `prodotto` 
                    SET `nome` = ?, 
                    `prezzo` = ?,
                    `quantita_disponibile` = ?,
                    `visibile` = ?, `foto` = ?, 
                    `descrizione` = ? 
                    WHERE `prodotto`.`id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sfiissi", $nome, $prezzo, $qta, $visible, $foto, $desc, $id);
        $stmt->execute();
    }

    public function insertNewProduct($nome, $prezzo, $qta, $visible, $foto, $desc, $vendorId)
    {
        $query = "INSERT INTO `prodotto` 
        (`id`, `nome`, `prezzo`, `quantita_disponibile`, `visibile`, `foto`, `descrizione`, `id_venditore`) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sfiissi", $nome, $prezzo, $qta, $visible, $foto, $desc, $vendorId);
        $stmt->execute();
    }

    public function setProductVisibilityFromId($id, $isVisible)
    {
        $query = "UPDATE `prodotto` SET `visibile` = ? WHERE `prodotto`.`id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $isVisible, $id);
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

    private function lastOrderIdByClientId($id)
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

    private function checkAlreadyInOrder($productId, $orderId)
    {

        $query = "SELECT * FROM collo WHERE id_prodotto = ? AND id_ordine = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $productId, $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        //echo $result->num_rows;
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

    public function setColloShipping($colloId, $shippingId)
    {
        $query = "UPDATE `collo` SET 
                    `id_spedizione` = ? 
                    WHERE `collo`.`id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $shippingId, $colloId);
        $stmt->execute();
    }

    //Ritorna true se ordina il prodotto, false se non si puo ordinare
    public function orderProduct($id, $quantity, $idCliente)
    {
        if ($quantity <= 0) {
            return false;
        }
        $orderId = $this->lastOrderIdByClientId($idCliente);
        if ($this->checkAlreadyInOrder($id, $orderId)) {
            $this->updateColloQuantity($quantity + $this->getColloQuantity($id, $orderId), $orderId, $id);
            return true;
        }
        $query = "INSERT INTO `collo` (`id`, `quantita_prodotto`, `id_prodotto`, `id_spedizione`, `id_ordine`) VALUES (NULL, ? , ? , NULL, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iii", $quantity, $id, $orderId);
        $stmt->execute();
        return true;
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

    //effettua un pagamento
    public function insertPayment($orderId, $orderCost, $cardCode)
    {
        $query = "INSERT INTO `pagamento` (`id`, `id_ordine`, `data`, `totale`, `codice_carta`) 
                    VALUES (NULL, ? , ? , ?, ?)";
        $stmt = $this->db->prepare($query);
        $date = date('Y-m-d H:i:s');
        $stmt->bind_param("isdi", $orderId, $date, $orderCost, $cardCode);
        $stmt->execute();
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
    public function decreaseOrderedProductQuantity($orderId)
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

    private function newshipping($orderId, $clientId)
    {
        //TODO
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
                $this -> setColloShipping($collo["id"],$shippingId);
            }
        }
    }

    private function checkPaid($orderId){
        $query = "SELECT * FROM pagamento WHERE id_ordine = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $orderId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->num_rows > 0 ? true : false;
    }

    private function newOrder($clientId){
        $query = "INSERT INTO `ordine` (`id`, `id_cliente`) VALUES (NULL, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $clientId);
        $stmt->execute();
    }

    //ritorna true se l'ordinazione è andata a buon fine false altrimenti
    public function startOrder($orderId, $cardCode, $clientId)
    {
        //Se manca qualche ordine
        if (!$this->checkOrderProducts($orderId) || $this->checkPaid($orderId)) {
            return false;
        }
        //calcola il costo totale dell ordine
        $orderCost = $this->getOrderCost($orderId);
        //effettua nuovo pagamento
        $this->insertPayment($orderId, $orderCost, $cardCode);
        //elimina le quantita di prodotti dal magazzino
        $this->decreaseOrderedProductQuantity($orderId);
        //TODO
        //crea le spedizioni
        $this -> newshipping($orderId, $clientId);
        //crea nuovo ordine
        $this -> newOrder($clientId);
        return true;
    }
}
