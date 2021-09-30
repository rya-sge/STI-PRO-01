<?php

// controleur.php
// Date de création : 24/12/2020
// Fonction : controleur
// _______________________________

require "modele/modele_BDD.php";
require "modele/modele_user.php";
require "modele/modele_administration.php";
require "modele/modele_algorithme.php";
require "modele/modele_code_source.php";
require "modele/modele_pseudo_code.php";
require "modele/modele_langage.php";
require "modele/modele_artefact.php";
require "modele/modele_famille.php";
require "modele/modele_note.php";
require "library/permission.php";
require "library/erreur.php";
require "library/traitementFichier.php";

define("ROOT_PSEUDO_CODE", "vue/pseudo_code");
define("ROOT_PROFIL", "vue/profil/");
define("ROOT_ALGORITHME", "vue/algorithme");
define("ROOT_CODE_SOURCE", "vue/code_source");
define("ROOT_FICHIERS", "contenu/fichiers/");
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









