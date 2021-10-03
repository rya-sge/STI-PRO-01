<?php
// vue_validation_gestion.php
// Date de création : 08/01/2021
// Fonction : vue pour afficher les contributions d'un utilisateur
// __________________________________________

$titre ='TheDeveloperSpellbook - Gestion des validations';

// Tampon de flux stocké en mémoire
ob_start();

?>
<script>
    const MSG_VALIDATION = "Êtes-vous sûr de valider cette demande. L'action est difficilement reversible";
    const MSG_SUPPRESSION = "Êtes-vous sûr de vouloir supprimer cette demande. L'action est irreversible";
</script>
<h2>En attente de validation</h2>
<article>
    <div class="row">
        <div class="col-lg-8">
            <p class="textModif"><?php
                if(isset($_SESSION['modif']))
                {
                    echo $_SESSION['modif'];
                    echo $_SESSION['modif']="";
                }?>
            </p>
            <?php require 'vue/boiteMail/vue_algorithme_validation.php';?>
            <?php require 'vue/pseudo_code/vue_pseudo_code_validation.php';?>
            <?php require 'vue/code_source/vue_code_source_validation.php';?>
        </div>
</article>
<hr/>
<?php
$contenu = ob_get_clean();
require 'gabarit.php';
?>


