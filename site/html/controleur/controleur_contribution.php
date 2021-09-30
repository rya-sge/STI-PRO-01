<?php
//Fonctions liées aux  contributions
//Date de création : 30.12.2020

/*
 * @brief gestion des contributions d'un utilisateur
 * @details N'attrape pas les exceptions.
 */
function contributionGestion()
{
	$algorithmeUnique = listeAlgorithmePourUnUtilisateur();
	$pseudoCode = listerPseudoCodePourUnUtilisateur();
	$codeSource = listeCodeSourcePourUnUtilisateur();
	require "vue/vue_contribution_gestion.php";
	
}
?>