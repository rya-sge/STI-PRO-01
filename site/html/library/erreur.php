<?php

// ------------ Erreur ---------------------
//Fonctions  de traitement des erreurs



/*
 * @brief Vérification du mode de passe proposé par l'utilisateur
 * @param passwdConf confirmation du mot de passe
 * @param passwdPost mot de passe entré par l'utilisateur
 * @throw exception si le mot de passe n'est pas valide
 * @details : cette fonction n'effectue aucune requête dans la BDD.
 */
function erreurPasswd($passwdConf, $passwdPost)
{
    if ($passwdConf != $passwdPost) {
        throw new Exception("Les mots de passes ne correspondent pas");
    }
}

function verifEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("L'adresse email n'est pas valide");
    }
}

?>
