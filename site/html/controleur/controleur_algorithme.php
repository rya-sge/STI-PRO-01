<?php
// ------------ Administration ---------------------
//Controleur pour la partie algorithme
//Date de création : 09.01.2020

/*
 * @brief récupération et affichage de la liste des algorithmes(validés)
 * @details N'attrape pas les exceptions.
 */
function algorithmeGestion()
{
    $familles = listerLesFamilles();
    $algorithme = listerLesAlgorithmesValider();
    $algorithmeUnique = listerAlgorithmeUnique();
    require ROOT_ALGORITHME . "/vue_algorithme_gestion.php";
}

/*
 * @brief récupération et affichage de la liste des pseudo-codes et code sources d'un algorithme
 */
function afficherAlgorithme_Artefact()
{
    try {
        if (isset($_GET['qIdAlgorithme'])) {
            testId($_GET['qIdAlgorithme']);
            $algorithme =  infoAlgorithme($_GET['qIdAlgorithme']);
            $estUnAlgo = True;
            $codeSource = listeCodeSourceAlgorithme($_GET['qIdAlgorithme']);
            $pseudoCode = listePseudoCodeAlgorithmeV($_GET['qIdAlgorithme']);
            $_SESSION['idAlgorithme_artefact'] = $_GET['qIdAlgorithme'];
            require ROOT_ALGORITHME . "/vue_algorithme.php";
            exit();
        } else if ($_SESSION['idAlgorithme_artefact']) {
            $algorithme =  infoAlgorithme($_SESSION['idAlgorithme_artefact']);
            $codeSource = listeCodeSourceAlgorithme($_SESSION['idAlgorithme_artefact']);
            $pseudoCode = listePseudoCodeAlgorithmeV($_SESSION['idAlgorithme_artefact']);
            $estUnAlgo = True;
            require ROOT_ALGORITHME . "/vue_algorithme.php";
            exit();
        } else {
            require ROOT_ALGORITHME . "/vue_algorithme_gestion.php";
        }
    } catch (Exception $e) {
        $_SESSION['erreur'] = $e->getMessage();
        algorithmeGestion();
    }

}


/*
 * @brief ajouter un algorithme
 */
function ajouterAlgorithme()
{
    //Variable post existe si l'utilisateur a cliqué sur le bouton Ajouter
    if (isset($_POST['AjoutAlgorithme'])) {
        if (isset($_POST['idFamille']) && sizeof($_POST['idFamille']) > 0){
            try {
                ajoutAlgorithme($_POST);
                //redirection ves la page de gestion des algorithmes
                @header("location: index.php?action=vue_algorithme_gestion");
                exit;
            } catch (Exception $e) {
                $_SESSION['erreur'] = $e->getMessage();
                //@header("location: index.php?action=vue_algorithme_add");
            }
        }
        else {
            $_SESSION['erreur'] = "Vous devez sélectionner au moins une famille";
        }
    }

    $famille = listerLesFamilles();
    require ROOT_ALGORITHME . "/vue_algorithme_add.php";
}

/*
 * @brief ajouter un algorithme
 * @throw Exception en cas d'erreur
 * @details
 * Fonction intermediaire, c'est pourquoi elle n'attrape pas les exceptions
 */
function supprimerAlgorithmeGenerique()
{
    //Variable post existe si l'utilisateur a cliqué sur le bouton supprimer
    if (isset($_GET['qIdAlgorithme'])) {
        testId($_GET['qIdAlgorithme']);
        suppAlgorithme($_GET['qIdAlgorithme']);
    } else {
        throw new Exception("Aucun algorithme de sélectionné");
    }
}

/*
 * @brief supprimer un algorithme
 */
function supprimerAlgorithme()
{
    try {
        supprimerAlgorithmeGenerique();
        @header("location: index.php?action=vue_algorithme_gestion");
        exit();
    } catch (Exception $e) {
        $_SESSION['erreur'] = "Cet algorithme ne peut pas être supprimé. Un algorithme ne peut pas être supprimé si il 
        est référencé dans une autre table.";
        @header("location: index.php?action=vue_algorithme_gestion");
        exit();
    }
}

/*
 * @brief supprimer un algorithme
 */
function supprimerMesAlgorithme()
{
    try {
        supprimerAlgorithmeGenerique();
        @header("location: index.php?action=vue_contribution_gestion");
        exit();
    } catch (Exception $e) {
        $_SESSION['erreur'] = "Cet algorithme ne peut pas être supprimé. Un algorithme ne peut pas être supprimé si il 
        est référencé dans une autre table.";
        @header("location: index.php?action=vue_contribution_gestion");
        exit();
    }
}

/*
 * @brief gère la suppression d'un algorithme depuis la page de validation
 */
function supprimerValidationAlgorithme()
{
    try {
        supprimerAlgorithmeGenerique();
        @header("location: index.php?action=vue_validation_gestion");
        exit();
    } catch (Exception $e) {
        $_SESSION['erreur'] = "Cet algorithme ne peut pas être supprimé. Un algorithme ne peut pas être supprimé si il 
        est référencé dans une autre table.";
        @header("location: index.php?action=vue_validation_gestion");
        exit();
    }
}

/*
 * @brief Effectuer une recherche d'algorithme
 */
function chercherAlgorithme(){
    try{
        if(isset($_POST['chercher'])){
            $algorithmeUnique  = searchAlgorithme($_POST['chercher']);
            $algorithme = $algorithmeUnique;
            $familles = listerLesFamilles();
            require ROOT_ALGORITHME . "/vue_algorithme_gestion.php";
        }else{
            throw new Exception("Erreur : Aucun paramètre de recherche");
        }
    }catch (Exception $e){
        $_SESSION['erreur'] = $e->getMessage();
        @header("location: index.php?action=vue_algorithme_gestion");
        exit();
    }

}

?>