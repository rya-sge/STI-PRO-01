<?php

// ------------ Erreur ---------------------
//Fonctions  de traitement des erreurs

/*
 * @brief Traitement des champs contenant du text donc des apostrophes
 * @param champ
 * @throw exception si une erreur est détecté
 * @return le champ traité avec la fonction htmlspecialchars
 */
function erreurXss($champ1)
{
    $champ2 = $champ1;
    $champ1 = htmlspecialchars($champ1, ENT_QUOTES);
    //$champ1=addslashes($champ1);
    if ($champ1 != $champ2) {
        throw new Exception("Les chevrons, les guillemets/apostrophes ainsi que certains caractères spéciaux 
        ne sont pas acceptés");
    }
}


/*
 * @brief Traitement des champs contenant du text donc des apostrophes
 * @param champ
 * @return le champ traité avec la fonction htmlspecialchars
 */
function traitementText($champ)
{
    $champ = htmlspecialchars($champ, ENT_QUOTES);
    return $champ;
}

/*
 * @brief Vérifier une url(injection sql)
 * @param champ
 * @throw exception si l'url n'est pas valide
 */
function erreurUrl($champ1)
{
    $champ2 = $champ1;
    $champ1 = htmlspecialchars($champ1);
    $champ1 = addslashes($champ1);
    if ($champ1 != $champ2) {
        throw new Exception("L'url de l'objet sélectionné est invalide");
    }
}

/*
 * @brief tester un id(valeur entière)
 * @param champ
 * @throw exception si l'id n'est pas valide
 */
function testId($champ1)
{
    if (!is_numeric($champ1)) {
        throw new Exception("L'id sélectionné est invalide");
    }
}

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
    $lengPasswd = strlen($passwdPost);
    if ($lengPasswd < 6) {
        throw new Exception("Le mot de passe est trop court. Il faut au moins 6 caractères");
    }
}

/*
 * @brief Vérification de la longueur d'un champ
 * @param champ à vérifier
 * @param nomChamp nom champ à afficher en cas d'erreur
 * @throw exception si le champ n'a pas la longueur requise
 */
function longChampValid($champ, $nomChamp, $length)
{
    $lengChamp = strlen($champ);
    if ($lengChamp > $length) {
        throw new Exception("Le champ " . $nomChamp . " est trop long. Il faut le raccourcir");

    }
}


/*
 * @brief Vérifier qu'un champ n'est pas vide
 * @param champ à vérifier
 * @param nomChamp nom champ à afficher en cas d'erreur
 * @throw exception si le champ est vide
 */
function champVide($champ, $nomChamp)
{
    if ($champ == "") {
        throw new Exception("Le champ " . $nomChamp . " doit être rempli");
    }
}

function verifEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("L'adresse email n'est pas valide");
    }
}

?>