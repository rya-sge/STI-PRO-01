<?php

// controleur.php
// Date de création : 24/12/2020
// Fonction : controleur
// _______________________________

require "modele/modele_BDD.php";
require "modele/modele_user.php";
require "modele/modele_email.php";
require "modele/modele_administration.php";
require "modele/modele_algorithme.php";

require "library/permission.php";
require "library/erreur.php";
require "library/traitementFichier.php";

define("ROOT_PROFIL", "vue/profil/");
define("ROOT_MAILBOX", "vue/mailbox");
define("NON_VALIDE", "En attente de validation");
define("VALIDE", "Validé");
define ("EXTENSIONS_DOC", array('.doc', '.docx', '.odt', '.pdf', '.zip', '.tar', '.rar', '.7z', '.txt'));
define("EXTENSIONS_FILE", array('.zip', '.tar', '.rar', '.7z'));
// Affichage de la page d'accueil
function accueil()
{
    if (isset($_SESSION['login'])) {
        require "vue/vue_accueil.php";
        exit;
    } else {
        require "vue/vue_visiteur.php";
    }
}

/*
 * Afficher la liste des messages
 */
function mailInbox(){
    $message = listMailInbox();
    require ROOT_MAILBOX. "/vue_inbox.php";
}

function readMessage(){

    if (isset($_GET['qIdMessage']))
    {
        $resultat = getMessageContent($_GET['qIdMessage']);
        require ROOT_MAILBOX. "/vue_message.php";

    }else{
        exit;
    }

}

// ------------ Autres ---------------------
function erreur($msg)
{
    $_SESSION['erreur'] = $msg;
    if (isset($_SESSION['login'])) {
        require "vue/erreur/vue_erreur.php";
    } else {
        require "vue/erreur/vue_erreur_visiteur.php";
    }
}









