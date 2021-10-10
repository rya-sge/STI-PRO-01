<?php

// controleur.php
// Date de création : 24/12/2020
// Fonction : controleur
// _______________________________
require "controleur/controleur_administration.php";


require "modele/modele_BDD.php";
require "modele/modele_user.php";
require "modele/modele_email.php";
require "modele/modele_administration.php";

require "library/permission.php";
require "library/erreur.php";

define("ROOT_PROFIL", "vue/profil/");
define("ROOT_MAILBOX", "vue/mailbox");
define("NON_VALIDE", "En attente de validation");
define("VALIDE", "Validé");

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

function addMessage()
{
    //Variable post existe si l'utilisateur a cliqué sur le bouton Ajouter
    if (isset($_POST['addMessage'])) {
            try {
                addMessageBdd($_POST);
                //redirection ves la page de gestion des algorithmes
               
            } catch (Exception $e) {
                $_SESSION['erreur'] = $e->getMessage();
                //@header("location: index.php?action=vue_algorithme_add");
            }
    }
    require ROOT_MAILBOX. "/vue_message_add.php";
}

function respondMessage(){
    //Variable post existe si l'utilisateur a cliqué sur le bouton répondre
  if (isset($_GET['qIdSender']) && isset($_GET['qIdMessage']))
  {

      $resultat = getMessageContent($_GET['qIdMessage']);
      require ROOT_MAILBOX. "/vue_message.php";
      $_POST['recipient'] = $_GET['qIdSender'];
      require ROOT_MAILBOX. "/vue_message_add.php";


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









