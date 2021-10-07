<?php
session_set_cookie_params(10000); // durée de vie de session  si > destruction automatique
session_start();

// index.php
// Date de création : 08/01/2021
// Fonction : page d'accueil
// _______________________________

require  'controleur/controleur.php';
require  'controleur/controleur_user.php';

try
{
  if (isset($_GET['action']))
  {
    $action = $_GET['action'];
    switch ($action)
    {
		case 'vue_accueil' :
			accueil();
			break;
		case 'vue_login' :
			login();
			break;
		case 'vue_logout':
			logout();
			break;
		case 'vue_inscription':
			addUser();
			break;
		case 'vue_passwd_reset':
			forgetPasswd();
			break;
		case 'vue_passwd_upd':
			updatePasswd();
			break;


		///inbox
		case 'vue_inbox':
		    mailInbox();
            break;

        case 'vue_message_read':
                readMessage();
                break;

        case 'vue_message_add':
            addMessage();
            break;
            
		////Contribution
		case 'vue_contribution_gestion':
            isConnected();
			contributionGestion();
			break;

        //Role
        case 'vue_role_gestion':
            isConnected();
            testR1Out();
            roleGestion();
            break;
        case 'vue_moderateur_ajout':
            isConnected();
            testR1Out();
            ajouterModerateur();
            break;
        case 'vue_moderateur_suppression':
            isConnected();
            testR1Out();
            supprimerModerateur();
            break;

            //Validation
        case 'vue_validation_gestion':
            isConnected();
            testR2Out();
            validationGestion();
            break;
        case 'vue_artefact_validation_supp':
            isConnected();
            testR2Out();
            supprimerValidationArtefact();
            break;
        case 'vue_algorithme_validation_supp':
            isConnected();
            testR2Out();
            supprimerValidationAlgorithme();
            break;

            //Algorithme
        case 'vue_algorithme_validation':
            isConnected();
            testR2Out();
            validationAlgorithme();
            break;
        case 'vue_algorithme_add':
            isConnected();
            ajouterAlgorithme();
            break;
        case 'vue_algorithme_gestion':
            isConnected();
            algorithmeGestion();
            break;
        case 'vue_algorithme':
            isConnected();
            afficherAlgorithme_Artefact();
            break;
        case 'vue_algorithme_suppression':
            isConnected();
            supprimerAlgorithme();
            break;
        case 'vue_mes_algorithme_suppression':
            isConnected();
            supprimerMesAlgorithme();
            break;
        case 'vue_algorithme_recherche':
            isConnected();
            chercherAlgorithme();
            break;
        //Artefact
        case 'vue_artefact_validation':
            isConnected();
            validationArtefact();
            break;
        case 'vue_artefact_suppression':
            isConnected();
            supprimerArtefact();
            break;
        case 'vue_mes_artefact_suppression':
            isConnected();
            supprimerMesArtefact();
            break;

        case 'vue_pseudo_code_liste_note':
            isConnected();
            noterArtefact(0);
            break;
        case 'vue_code_source_liste_note':
            isConnected();
            noterArtefact(1);
            break;
        case 'vue_artefact_algorithme_note':
            isConnected();
            noterArtefact(2);
            break;

        //profil
		case 'vue_profil':
            isConnected();
            profil();
            break;
		case 'vue_profil_login_upd':
            isConnected();
            updateLogin();
            break;
		case 'vue_profil_email_upd':
            isConnected();
            updateEmail();
            break;
		case 'vue_profil_passwd_modif':
            isConnected();
            modifPasswd();
            break;
		case 'vue_profil_del':
            isConnected();
            deleteUser();
            break;
     default :
        throw new Exception("L'action demandée est inconnue !");
    }   
  }
  else
    accueil();
  
}
catch (Exception $e)
{
  erreur($e->getMessage());
}
