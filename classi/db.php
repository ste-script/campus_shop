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

    public function insertNewProduct($nome, $prezzo, $qta, $visible, $foto, $desc, $vendor_id)
    {
        $query = "INSERT INTO `prodotto` 
        (`id`, `nome`, `prezzo`, `quantita_disponibile`, `visibile`, `foto`, `descrizione`, `id_venditore`) 
        VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("sfiissi", $nome, $prezzo, $qta, $visible, $foto, $desc, $vendor_id);
        $stmt->execute();
    }

    public function setProductVisibilityFromId($id, $isVisible)
    {
        $query = "UPDATE `prodotto` SET `visibile` = ? WHERE `prodotto`.`id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $isVisible, $id);
        $stmt->execute();
    }

    private function checkProductQuantity($id)
    {
        $stmt = $this->db->prepare("SELECT  quantita_disponibile
                                    FROM prodotto
                                    WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        //echo $result->fetch_assoc()["quantita_disponibile"];
        return $result->fetch_assoc()["quantita_disponibile"] > 0 ? true : false;
    }

    public function orderProduct($id)
    {
        /*$query = "UPDATE `prodotto` SET `visibile` = ? WHERE `prodotto`.`id` = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $isVisible, $id);
        $stmt->execute();*/
        return $this->checkProductQuantity($id);
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
