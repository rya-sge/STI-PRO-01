<?php
// ------------ Famille ---------------------
//Fonctions liées à la table Famille
// -----------------------------

/*
 * @brief Sélectionner les familles
 * @return objet PDOStatement
 */
function listerLesFamilles()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT *
                FROM Famille;";
    // Exécution de la requete
    $resultats = $db->query($requete);
    return $resultats->fetchAll();
}


?>
