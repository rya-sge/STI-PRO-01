<?php
// ------------ Administration ---------------------
//Contrôleur de la partie administration
//Date de création : 8.01.2020


/*
 * @brief gère le rôle des utilisateurs
 */
function roleGestion()
{
    $resultats = listUser();
    require "vue/administration/vue_user_gestion.php";
}

function updUserRole(){
    if (isset($_GET['qIdUser']) && isset($_POST['role'])) {
        try {
            updateRoleById($_GET['qIdUser'], $_POST['role']);
        } catch (Exception $e) {
            $_SESSION['erreur'] = $e->getMessage();
        }
    }
    @header("location: index.php?action=vue_role_gestion");
    exit();
}
?>
