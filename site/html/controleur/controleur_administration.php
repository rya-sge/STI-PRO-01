<?php
// ------------ Administration ---------------------
//Contrôleur de la partie administration
//Date de création : 8.01.2020


/*
 * @brief gère le rôle des utilisateurs
 */
function roleGestion()
{
    $resultats = listeModerateur();
    require "vue/vue_role_gestion.php";
}

/*
 * @brief lister le contenu (Algortihme et pseudo-code) en attente de validation
 */
function validationGestion()
{
    $algorithmeUnique = listeAlgorithmeValidation();
    $pseudoCode = listePseudoCodePourValidation();
    $codeSource = listeCodeSourceValidation();
    require "vue/vue_validation_gestion.php";
}

/*
 * @brief gère la validation d'un artefact
 */
function validationArtefact()
{
    try {
        testId($_SESSION['idUser']);
        testId($_GET['qIdArtefact']);
        validerArtefact($_GET['qIdArtefact'], $_SESSION['idUser']);
    } catch (Exception $e) {
        $_SESSION['erreur'] = $e->getMessage();
    }
    header("location: index.php?action=vue_validation_gestion");
    exit();
}

/*
 * @brief gère la validation d'un boiteMail
 */
function validationAlgorithme()
{
    try {
        testId($_SESSION['idUser']);
        testId($_GET['qIdAlgorithme']);
        validerAlgorithme($_GET['qIdAlgorithme'], $_SESSION['idUser']);
    } catch (Exception $e) {
        $_SESSION['erreur'] = $e->getMessage();
    }
    header("location: index.php?action=vue_validation_gestion");
    exit();
}

/*
 * @brief gère l'ajout d'un modérateur
 * @Details :
 * Cette fonction est actuellement vulnérable à l'attaque csrf
 */
function ajouterModerateur()
{
    if (isset($_POST['AjoutModerateur'])) {
        try {
            erreurXss($_POST['AjoutModerateur']);
            updateRoleByName($_POST['nom'], 2);
            //redirection ves la page de gestion des utilisateurs
            @header("location: index.php?action=vue_role_gestion");
            exit;
        } catch (Exception $e) {
            $_SESSION['erreur'] = $e->getMessage();
        }
    }
    require "vue/vue_role_add.php";
}

/*
 * @brief gère la suppression d'un modérateur
 * @details : Le role de l'utilisateur est modifié à un rôle inférieur
 */
function supprimerModerateur()
{
    if (isset($_GET['qIdUtilisateur'])) {
        try {
            testId($_GET['qIdUtilisateur']);
            updateRoleById($_GET['qIdUtilisateur'], 3);
        } catch (Exception $e) {
            $_SESSION['erreur'] = $e->getMessage();
        }
    }
    @header("location: index.php?action=vue_role_gestion");
    exit();
}

?>
