<?php
// ------------ Artefact ---------------------
//Fonctions liées à la table Artefact

// -----------------------------

/*
 * @brief Validation d'un artefact
 * @param id de l'artefact à valider
 * @return objet PDOStatement
 */
function validerArtefact($idArtefact, $idUtilisateur)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = $db->prepare("UPDATE Artefact 
                                      SET estValide = True, idUtilisateur_Validation = " . $idUtilisateur ."
                                      WHERE id = '" . $idArtefact . "'");
    // Exécution de la requete
    $requete->execute();
    if ($requete->rowCount()) {
        $_SESSION['modif'] = "Le pseudo-code ou code source a été mis à jour";
    } else {
        $_SESSION['modif'] = "Erreur : Le pseudo-code ou code source n'a pas pu être mis à jour";
    }
}

/*
 * @brief Mise à jour de la description artefact
 * @param id de l'artefact
 * @param description
 * @return nombre de lignes affectées par la requête
 * @details : Fonction intermediaire
 */
function updateArtefact($id, $description)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = $db->prepare("UPDATE Artefact 
                                      SET description = '".$description."'
                                      WHERE id = '".$id."' ;");
    // Exécution de la requete
    $requete->execute();
    return $requete->rowCount();
}

/*
 * @brief Ajout d'un artefact
 * @param id de l'utilisateur
 * @param id de l'algorithme
 * @param description
 * @return id de l'artefact inséré
 * @details
 * Fonction intermediaire, ne modifie pas les variables de session
 */
function ajouterArtefact($idUser, $idAlgorithme, $description)
{
    $db = getBD();
    $req = $db->prepare('INSERT INTO Artefact (idUtilisateur_Createur, description, dateAjout, dateModification, idAlgorithme)
					VALUES (:idUtilisateur_Createur, :description, :dateAjout, :dateModification, :idAlgorithme)');
    $req->execute(array(
        'idUtilisateur_Createur' => $idUser,
        'description' => $description,
        'dateAjout' => date('Y-m-d H:i:s'),
        'dateModification' => date('Y-m-d H:i:s'),
        'idAlgorithme' => $idAlgorithme
    ));
    return $db->lastInsertId();
}

/*
 * @brief chercher un artefact
 * @param idArtefact à chercher
 * @param idUtilisateur
 * @return objet PDOStatement
 */
function chercherUnArtefact($idArtefact, $idUtiisateur)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = 'SELECT *
                FROM Artefact
                WHERE id = "' . $idArtefact . '"
                    AND idUtilisateur_Createur = "' . $idUtiisateur . '";';
    // Exàcution de la requete
    return $db->query($requete);
}

// -----------------------------
/*
 * @brief supprimer un  artefact
 * @param idArtefact
 *
 */
function suppArtefact($idArtefact, $verif)
{
    try {
        $db = getBD();
        if($verif){
            //Recherche de l'artefact avec l'id de l'utilisateur.
            //Cette recherche empêche un utilisateur de supprimer un autre artefact que le sien.
            $res = chercherUnArtefact($idArtefact, $_SESSION['idUser']);
            $ligne = $res->fetch(); // récupère la valeur de l'artefact sélectionné s'il y en a un
            //Test le résultat
            if (empty($ligne['id'])) {
                throw new Exception("La suppression n'a pas pu avoir lieu.
                                         Etes - vous bien le créateur de ce code source ou pseudo-code ?");
            }
        }
        try {
            delArtefact($idArtefact);
            $_SESSION['modif'] = "La suppression a réussie";
        } catch (Exception $e) {
            trigger_error($e->getMessage(), E_USER_ERROR);
            $_SESSION['erreur'] = $e->getMessage();
        }
    } catch (Exception $e) {
        $_SESSION['erreur'] = $e->getMessage();
    }

}


/*
 * @brief supprimer un artefact
 * @param idArtefact à supprimer
 */
function delArtefact($idArtefact)
{
    // suppression de la base de données
    $db = getBD();
    $requete = "DELETE 
                FROM Artefact 
                WHERE id = $idArtefact;";
    $db->exec($requete);

    // suppression du stockage
}

?>
