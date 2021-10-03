<?php
// ------------ Algorithme ---------------------
//Fonctions liées à la table Algorithme

// -----------------------------

/*
 * @brief Sélection des algorithmes
 * @return tableau contenant toutes les lignes résultantes de la requête
 */
function listerLesAlgorithmesValider()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT * 
                FROM vAlgorithme 
                WHERE estValide = TRUE
                ORDER BY nom;";
    // Exécution de la requete
    return $db->query($requete)->fetchAll();
}

/*
 * @brief Sélection des algorithmes sans doublons (mais sans familles)
 * @return tableau contenant toutes les lignes résultantes de la requête
 */
function listerAlgorithmeUnique()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT * 
                FROM Algorithme 
                WHERE estValide = TRUE
                ORDER BY nom;";
    // Exécution de la requete
    return $db->query($requete)->fetchAll();
}

/*
 * @brief Sélection des algorithmes créés par l'utilisateur connecté
 * @return objet PDOStatement
 */
function listeAlgorithmePourUnUtilisateur()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT * 
                FROM Algorithme 
                WHERE idUtilisateur_Createur ='" . $_SESSION["idUser"] . "' 
                ORDER BY dateModification DESC;";
    // Exécution de la requete
    return $db->query($requete)->fetchAll();
}

/*
 * @brief Sélection des algorithmes en attente de validation
 * @return objet PDOStatement
 */
function listeAlgorithmeValidation()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT * 
                FROM Algorithme 
                WHERE estValide = FALSE 
                ORDER BY nom;";
    // Exécution de la requete
    return $db->query($requete)->fetchAll();
}

/*
 * @brief Sélection des algorithmes en attente de validation
 * @param id de l'boiteMail dont on souhaite récupérer les infos dans la BDD
 * @return tuple de l'boiteMail recherché
 */
function infoAlgorithme($id)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT * 
                FROM vAlgorithme 
                WHERE id = '" . $id . "'";
    // Exécution de la requete
    $res = $db->query($requete);
    return $res->fetch();
}

/*
 * @brief Validation d'un boiteMail
 * @param id de l'boiteMail
 */
function validerAlgorithme($idAlgorithme, $idUtilisateur)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = $db->prepare("
                UPDATE Algorithme
                SET estValide = True, idUtilisateur_Validation = "."$idUtilisateur"."
                WHERE id = '" . $idAlgorithme . "'");
    // Exécution de la requete
    $requete->execute();
    if ($requete->rowCount()) {
        $_SESSION['modif'] = "L'boiteMail a été validé";
    } else {
        $_SESSION['modif'] = "Erreur : L'boiteMail n'a pas pu être validé";
    }
}


/*
 * @brief Ajouter un boiteMail
 * @param Donnée POST du formulaire
 * @details
 * Source utilisée pour le traitement des checkbox : https://makitweb.com/get-checked-checkboxes-value-with-php/
 */
function ajoutAlgorithme($postArray)
{
    $db = getBD();
    //Récupération des données passées en post
    $nom = $postArray ["nom"];
    $tag = $postArray ["tag"];
    $presentation = traitementText($postArray ["presentation"]);
    $tag = traitementText($tag);
    $nom = traitementText($nom);

    // test si le nom de l'boiteMail existe déjà pour éviter des erreurs sql sur les doublons
    $reqSelect = "SELECT id 
                  FROM Algorithme 
                  WHERE nom = '" . $nom . "';";
    $res = $db->query($reqSelect);
    $ligne = $res->fetch(); // récupère le tuple sélectionné s'il y en a un
    // Test le résultat
    if (empty($ligne['id'])) {
        // ajout de l'activité
        $req = $db->prepare('INSERT INTO Algorithme (nom, tag, presentation, dateAjout, dateModification, 
                                                                idUtilisateur_Createur)
                                      VALUES (:nom, :tag, :presentation, :dateAjout, :dateModification, :idUtilisateur_Createur)');
        $req->execute(array(
            'nom' => $nom,
            'tag' => $tag,
            'presentation' => $presentation,
            'dateAjout' => date('Y-m-d H:i:s'),
            'dateModification' => date('Y-m-d H:i:s'),
            'idUtilisateur_Createur' => $_SESSION['idUser'],
        ));
        $_SESSION['modif'] = "L'boiteMail a été ajouté. Il est en attente de validation de la part d'un modérateur";
        $idAlgorithme = $db->lastInsertId();

        if (isset($postArray['idFamille'])) {
            try {
                foreach ($postArray['idFamille'] as $value) {
                    testId($value);
                    $req = $db->prepare('INSERT INTO Famille_Algorithme (idFamille, idAlgorithme)
                                           VALUES (:idFamille, :idAlgorithme)');
                    $req->execute(array(
                        'idFamille' => $value,
                        'idAlgorithme' => $idAlgorithme
                    ));
                }
            } catch (Exception $e) {
                //Si erreur lors de l'insertion, on supprime les tuples insérés pour revenir à l'état initial
                $requete = 'DELETE FROM Famille_Algorithme
                            WHERE idAlgorithme="' . $idAlgorithme . '" ;';
                $db->exec($requete);
                suppAlgorithme($idAlgorithme);
                throw new Exception("Des erreurs sont survenus lors de l'insertion des familles.");
            }
        }
    } else {
        throw new Exception("L'boiteMail ne peut pas être ajouté car il existe déjà.");
    }
}


/*
 * @brief chercher un boiteMail
 * @param idAlgorithme à chercher
 * @param idUtilisateur
 * @return objet PDOStatement
 */
function chercherUnAlgorithme($idAlgorithme, $idUtiisateur)
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = 'SELECT *
                FROM Algorithme
                WHERE id = "' . $idAlgorithme . '"
                    AND idUtilisateur_Createur = "' . $idUtiisateur . '";';
    // Exécution de la requete
    return $db->query($requete);
}

/*
 * @brief supprimer un boiteMail
 * @param L'id de l'boiteMail à supprimer
 */
function suppAlgorithme($idAlgorithme)
{
    $db = getBD();
    $res = chercherUnAlgorithme($idAlgorithme, $_SESSION['idUser']);
    $ligne = $res->fetch(); // récupère la valeur de l'artefact sélectionné s'il y en a un
    //Test le résultat
    if (empty($ligne['id'])) {
        throw new Exception("La suppression n'a pas pu avoir lieu.
                                         Etes - vous bien le créateur de cet boiteMail ?");
    }
    $requete = 'DELETE 
                FROM Algorithme 
                WHERE id ="' . $idAlgorithme . '" ;';
    $requete = $db->exec($requete);
    if ($requete) {
        $_SESSION['modif'] = "L'boiteMail a été supprimé";
    } else {
        $_SESSION['modif'] = "Erreur : L'boiteMail n'a pas pu être  supprimé";
    }


}

/*
 * @brief effectuer une recherche d'boiteMail
 * @param Donnée POST du formulaire
 */
function searchAlgorithme($postArray)
{
    $db = getBD();
    $tags = explode(',', $postArray);
    $listeTags = "";
    foreach ($tags AS $tag) {
        $tag =  traitementText($tag);
        $listeTags .= "%$tag%";
    }
    $requete = "SELECT * FROM vAlgorithme WHERE tag LIKE '" . $listeTags . "' OR nom LIKE '" . $listeTags . "';";
    return $db->query($requete)->fetchALl();
}
