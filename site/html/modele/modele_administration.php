<?php

// ------------ Administration ---------------------
//Fonctions liées à l'administration

/*
 * @brief afficher la liste des utilisateurs ayant pour rôle 2
 * @return objet PDOStatement de la liste obtenue
 */
function listeModerateur(){
    $db = getBD();
    // Création de la string pour la requête
    $requete = "SELECT * 
                FROM Utilisateur 
                WHERE  idRole = 2 
                ORDER BY id;";
    // Exécution de la requete
    return $db->query($requete);
}



?>