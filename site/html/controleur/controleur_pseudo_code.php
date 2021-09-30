<?php
//Controleur pour la partie pseudo Code
//Date de création : 09.01.2020


/*
 * @brief gère la récupèration et l'affichage des pseudo-codes valides.
 */
function pseudoCodeGestion()
{
    $pseudoCode = listerLesPseudoCodesParDateV();
    require ROOT_PSEUDO_CODE . "/vue_pseudo_code.php";
}

/*
 * @brief gère l'ajout de pseudo-code
 */
function ajouterPseudoCode()
{
    try {
        if (isset($_SESSION['idAlgorithme_artefact'])) {



            if (isset($_POST['ajouterPseudoCode'])) {
                try {
                    ajoutPseudoCode($_POST);
                    @header("location: index.php?action=vue_algorithme");
                    exit();
                } catch (Exception $e) {
                    $_SESSION['erreur'] = $e->getMessage();
                    @header("location: index.php?action=vue_pseudo_code_ajout");
                    exit();
                }
            } else {
                require ROOT_PSEUDO_CODE . "/vue_pseudo_code_add.php";
            }
        } else {
            throw new Exception("Aucun algorithme de sélectionné");
        }
    } catch (Exception $e) {
        $_SESSION['erreur'] = $e->getMessage();
    }
}

/*
 * @brief gère  le téléchargement de pseudo-code
 */
function telechargerPseudoCode()
{
    try {
        if (isset($_GET['idPseudoCode'])) {
            testId($_GET['idPseudoCode']);
            downloadPseudoCode($_GET['idPseudoCode']);
        } else {
            throw new Exception("Aucun pseudo-code sélectionné");
        }
    } catch (Exception $e) {
        $_SESSION['erreur'] = $e->getMessage();
    }
}

/*
 * @brief gère  l'affichage du texte d'un pseudo-code
 */
function afficherTexte()
{
    try {
        if (isset($_GET['qIdPseudoCode'])) {
            testId($_GET['qIdPseudoCode']);
            $texte = getPseudoCodeTexte($_GET['qIdPseudoCode']);
            require ROOT_PSEUDO_CODE . "/vue_pseudo_code_texte.php";
        } else {
            throw new Exception("Aucun pseudo-code sélectionné");
        }
    } catch (Exception $e) {
        $_SESSION['erreur'] = $e->getMessage();
        @header("location: index.php?action=vue_pseudo_code_gestion");
    }
}
?>