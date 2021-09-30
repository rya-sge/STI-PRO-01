<?php
//Controleur pour la partie code source
//Date de création : 9.01.2020

/*
 * @brief gère la récupèration et l'affichage des codes sources valides.
 */
function codeSourceGestion()
{
    $codeSource = listerLesCodesSourcesValide();
    require ROOT_CODE_SOURCE . "/vue_code_source.php";
}

/*
 * @brief gère l'ajout de code source
 */
function ajouterCodeSource()
{
    if (isset($_SESSION['idAlgorithme_artefact'])) {
        if (isset($_POST['ajouterCodeSource'])) {
            try {
                ajoutCodeSource($_POST);
                @header("location: index.php?action=vue_algorithme");
                exit();
            } catch (Exception $e) {
                $_SESSION['erreur'] = $e->getMessage();
                @header("location: index.php?action=vue_code_source_ajout");
                exit();
            }

        } else {
            $resultats = listerLesLangages();
            require ROOT_CODE_SOURCE . "/vue_code_source_add.php";
        }
    } else {
        $_SESSION['erreur'] = "Aucun algorithme de sélectionné";
        @header("location: index.php?action=vue_algorithme_gestion");
    }
}

/*
 * @brief gère le téléchargement de code source
 * @type attribut du document dans la BDD
 * @details
 * Pas de redirection en cas d'erreur car on ne sait pas d'où provient l'utilisateur
 */
function telechargerCodeSource($type)
{
    try {
        if (isset($_GET['idCodeSource'])) {
            testId($_GET['idCodeSource']);
            downloadCodeSource($_GET['idCodeSource'], $type);
        } else {
            throw new Exception("Aucun code source sélectionné");
        }
    } catch (Exception $e) {
        $_SESSION['erreur'] = $e->getMessage();
    }
}

/*
 * @brief gère la modification de code source
 * @details
 * TODO: Vérifier que l'utilisateur a le droit de modifier le code source
 * (Rôle ou idUtilisateur_Créateur)
 */
function modifierMesCodeSource()
{

    if (isset($_POST['modifierCodeSource']) && isset($_SESSION['idCodeSource'])) {
        try {
            updateCodeSource($_SESSION['idCodeSource'], $_POST);
            $_SESSION['idCodeSource'] = "";
            @header("location: index.php?action=vue_contribution_gestion");
            exit();
        } catch (Exception $e) {
            $_SESSION['erreur'] = $e->getMessage();
            @header("location: index.php?action=vue_contribution_gestion");
            exit();
        }

    } elseif (isset($_GET['qIdCodeSource'])) {
        try {
            testId($_GET['qIdCodeSource']);
            $langages = listerLesLangages();
            $infoCodeSource = infoMesCodeSource($_GET['qIdCodeSource']);
            $_SESSION['idCodeSource'] = $_GET['qIdCodeSource'];
            require ROOT_CODE_SOURCE . "/vue_code_source_upd.php";
        } catch (Exception $e) {
            $_SESSION['erreur'] = $e->getMessage();
            @header("location: index.php?action=vue_contribution_gestion");
            exit();
        }

    } else {
        $_SESSION['erreur'] = "Aucun code source de sélectionné";
        @header("location: index.php?action=vue_contribution_gestion");
    }

}

/*
 * @brief gère l'attribution d'un pseudo code à un code source
 * @details
 * TODO: Vérifier que l'utilisateur a le droit de modifier le code source
 * (Rôle ou idUtilisateur_Créateur)
 */
function attacherPseudoCode()
{
    if(isset($_POST['idPseudoCode']) && isset($_POST['idCodeSource'])) {
        try {
            testId($_POST['idPseudoCode']);
            testId($_POST['idCodeSource']);
            attachPseudoCode($_POST['idPseudoCode'], $_POST['idCodeSource']);
            @header("location: index.php?action=vue_algorithme");
        }

        catch (Exception $e) {
            $_SESSION['erreur'] = $e->getMessage();
            exit();
        }
    }
    else {
        $_SESSION['erreur'] = "Aucun code source ou pseudo-code sélectionné". $_POST['idCodeSourceCode'];
        http://localhost/sp/index.php?action=vue_algorithme&qIdAlgorithme=2
        @header("location: index.php?action=vue_algorithme_gestion");
    }



}
?>
