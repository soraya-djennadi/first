<?php
    public function insert() {
        global $bdd;
        $sql = "INSERT INTO `fiche` SET `titre`=:titre,"
                . "`contenu`=:contenu,"
                . "`resume`=:resume,"
                . "`auteur`=:auteur,"
                . "`date_saisie`= NOW(),"
                . "`categorie`=:categorie";
        $param = [":titre" => $_POST["titre"],
            ":contenu" => $_POST["contenu"],
            ":resume" => $_POST["resume"],
            ":auteur" => $_SESSION["id"],
            ":categorie" => $_POST["categorie"]];
        if (!empty($_FILES)) {
            $name = $_FILES["photo"]["name"];
            $file_extension = strrchr($name, ".");
            $destination = "img/" . $name;
            $temp = $_FILES["photo"]["tmp_name"];
            $extension_autorized = array(".jpg", ".jpeg", ".bmp", ".gif", ".png", ".JPG", ".JPEG", ".BMP", ".GIF", ".PNG");
            if (in_array($file_extension, $extension_autorized)) {
                if (move_uploaded_file($temp, $destination)) {
                    $sql .= ", `photo`=:photo";
                    $param[","];
                    $param[":photo"] = $destination;
                }
            }
            debug("il y a un fichier");
            $req = $bdd->prepare($sql);
            if (!$req->execute($param)) {
                return false;
            }
            if ($req->rowCount() === 1) {
                $this->id = $bdd->lastInsertId();
                return true;
            }
        } else {
            $req = $bdd->prepare($sql);
            if (!$req->execute($param)) {
                return false;
            }
            if ($req->rowCount() === 1) {
                $this->id = $bdd->lastInsertId();
                return true;
            }
        }
    }
