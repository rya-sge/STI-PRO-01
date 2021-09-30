<?php
// ------------ Langage ---------------------
//Fonctions liées à la table Langage
// -----------------------------

/*
 * @brief Sélectionner les langages
 * @return objet PDOStatement
 */
function listerLesLangages()
{
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT id, nom 
                FROM Langage;";
    // Exécution de la requete
    $resultats = $db->query($requete);
    return $resultats;
}
?>
