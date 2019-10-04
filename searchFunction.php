<?php
  public function research($motClef) {
        global $bdd;
        $sql = "SELECT * FROM `fiche` WHERE 1";
        $param = [];
        if (!empty($motClef)) {
            $sql .= " AND `titre` LIKE :titre";
            $param [":titre"] = "%$motClef%";
        }
        //rechercher dans le contenu
        if (!empty($motClef)) {
            $sql .= " OR `contenu` LIKE :contenu";
            $param [":contenu"] = "%$motClef%";
        }
        $req = $bdd->prepare($sql);
        if (!$req->execute($param)) {
            return [];
        }
        while ($ligne = $req->fetch(PDO::FETCH_ASSOC)) {
            $fiche = new fiche();
            $fiche->loadById($ligne["id"]);
            $result[] = $fiche;
        }

        return $result;
    }
