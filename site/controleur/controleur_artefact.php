<?php
// ------------ Artefact ---------------------
//Contrôleur de la partie Artefact
//Date de création : 11.01.2020


/*
 * @brief supprimer un artefact
 * @param verif boolean indiquant si il faut vérifier que
 * l'utilisateur qui supprime l'artefact est le créateur de l'artefact
 * @throw Exception en cas d'erreur
 * @details
 * Fonction intermediaire, c'est pourquoi elle n'attrape pas les exceptions
 */
function supprimerArtefactGenerique($verif)
{
    if (isset($_GET['qIdArtefact'])) {
        testId($_GET['qIdArtefact']);
        suppArtefact($_GET['qIdArtefact'], $verif);
    } else {
        throw new Exception("Aucun code source ou pseudo-code de sélectionné");
    }
}

/*
 * @brief Gère la suppression d'artefact depuis la page de validation_gestion
 */
function supprimerValidationArtefact()
{
    try {
        supprimerArtefactGenerique(false);
        @header("location: index.php?action=vue_validation_gestion");
        exit();
    } catch (Exception $e) {
        $_SESSION['erreur'] = $e->getMessage();
        @header("location: index.php?action=vue_validation_gestion");
        exit();
    }
}

/*
 * @brief Gère  la suppression d'artefact depuis la page algorithme
 * @details : fonction de suppression pour les admins/modérateurs
 */
function supprimerArtefact()
{
    try {
        supprimerArtefactGenerique(True);
        @header("location: index.php?action=vue_algorithme");
        exit();
    } catch (Exception $e) {
        $_SESSION['erreur'] = $e->getMessage();
        @header("location: index.php?action=vue_algorithme");
        exit();
    }
}

/*
 * @brief Gère  la suppression des artefacts propres à un utilisateur
 */
function supprimerMesArtefact()
{
    try {
        supprimerArtefactGenerique(True);
    } catch (Exception $e) {
        $_SESSION['erreur'] = $e->getMessage();
    }
    @header("location: index.php?action=vue_contribution_gestion");
}

/*
 * @brief noter un artefact
 * @param from indiquant de quelle page provient l'utilisateur
 */
function noterArtefact($from)
{
    switch ($from) {
        case 0://Pseudo-code liste
            $dest = "location: index.php?action=vue_pseudo_code_gestion";
            break;
        case 1://Code-source liste
            $dest = "location: index.php?action=vue_code_source_gestion";
            break;
        case 2://Algorithme
            $dest = "location: index.php?action=vue_algorithme";
            break;
        default:
            $dest = "location: index.php?action=vue_accueil";
    }
    if (isset($_POST['note']) && isset($_GET['qIdArtefact'])) {
        try {
            testId($_GET['qIdArtefact']);
            testId($_POST['note']);
            ajouterNote($_GET['qIdArtefact'], $_SESSION['idUser'], $_POST['note']);
        } catch (Exception $e) {
            $_SESSION['erreur'] = $e->getMessage();
        }
        @header($dest);
    } else {
        $_SESSION['erreur'] = "Aucune note ou artefact n'est sélectionné";
        @header($dest);
    }

}

?>
