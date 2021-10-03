<?php
// vue_contribution_gestion.php
// Date de création : 08/01/20121
// Fonction : vue pour afficher les contributions d'un utilisateur
// __________________________________________

$titre = 'TheDeveloperSpellbook - Gestion des contributions';
// Tampon de flux stocké en mémoire
ob_start();

?>
<p class="textModif"><?php
    if (isset($_SESSION['modif'])) {
        echo $_SESSION['modif'];
        echo $_SESSION['modif'] = "";
    } ?>
</p>
<h2>Liste de vos contributions</h2>
<article>
    <div class="row">
        <div class="col-lg-8">
            <p class="textModif"><?php
                if (isset($_SESSION['modif'])) {
                    echo $_SESSION['modif'];
                    echo $_SESSION['modif'] = "";
                } ?>
            </p>

            <?php require 'vue/code_source/vue_code_source_contribution.php'; ?>
            <?php require 'vue/boiteMail/vue_algorithme_contribution.php'; ?>
            <?php require 'vue/pseudo_code/vue_pseudo_code_contribution.php'; ?>
        </div>
    </div>
</article>
<hr/>
<?php
$contenu = ob_get_clean();
require 'gabarit.php';
?>  
      
      
