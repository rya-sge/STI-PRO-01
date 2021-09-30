<?php
// ------------ Note ---------------------
//Fonctions liées à la table Note
// -----------------------------
/*
     * @brief Ajout d'un artefact
     * @return id de l'artefact inséré
     * @param id de l'utilisateur
     * @param id de l'algorithme
     * @param description
     * @details
     * Fonction intermediaire, ne modifie pas les variables de session
     */
    function ajouterNote($idArtefact, $idUtilisateur, $valeur)
    {
        $db = getBD();
        $date =  date('Y-m-d H:i:s');
        $reSelect = "SELECT * FROM Note 
                     WHERE idArtefact = '".$idArtefact."' 
                        AND idUtilisateur = '".$idUtilisateur."'";
        $res = $db->query($reSelect);
        $ligne = $res->fetch(); // récupère la valeur du login sélectionné s'il y en a un
        // Test le résultat
        if (empty($ligne['idArtefact'])) {
            $req = $db->prepare("INSERT INTO Note (idArtefact, idUtilisateur, valeur, date)
                        VALUES (:idArtefact, :idUtilisateur, :valeur, :date)");
            $req->execute(array(
                'idArtefact' =>$idArtefact,
                'idUtilisateur' => $idUtilisateur,
                'valeur' =>$valeur,
                'date' => $date
            ));
        }else{
            $requete = $db->prepare("UPDATE Note 
                                      SET 
                                        valeur = '".$valeur."',
                                        date = '".$date."'
                                      WHERE idArtefact = '".$idArtefact."'
                                       AND idUtilisateur = '".$idUtilisateur."';");
            // Exécution de la requete
            $requete->execute();
        }
    }
?>