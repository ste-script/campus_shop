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
        return $result->fetch_assoc()["quantita_disponibile"] > $quantity ? true : false;
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
}

    /*public function getRandomPosts($n = 2)
    {
        $stmt = $this->db->prepare("SELECT idarticolo, titoloarticolo, imgarticolo FROM articolo ORDER BY RAND() LIMIT ?");
        $stmt->bind_param("i", $n);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getCategories()
    {
        $stmt = $this->db->prepare("SELECT idcategoria, nomecategoria FROM categoria");
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getPosts($n = -1)
    {
        $query = "SELECT idarticolo, titoloarticolo, imgarticolo, dataarticolo, anteprimaarticolo, nome  FROM articolo, autore WHERE autore=idautore ORDER BY dataarticolo DESC";
        if ($n > 0) {
            $query = $query . " LIMIT ?";
        }
        $stmt = $this->db->prepare($query);
        if ($n > 0) {
            $stmt->bind_param("i", $n);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function getAuthors()
    {
        $query = "SELECT username, nome, GROUP_CONCAT(DISTINCT
        nomecategoria) as argomenti FROM categoria,
        articolo, autore, articolo_ha_categoria WHERE
        idarticolo=articolo AND categoria=idcategoria AND
        autore=idautore AND attivo=1 GROUP BY username,
        nome";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }*/
