<?php
// vue_pseudo_code.php
// Date de création : 09/01/2021
// Fonction : vue pour afficher une liste de codes sources
// __________________________________________

$titre ='TheDeveloperSpellbook - Gestion des codes sources';

// Tampon de flux stocké en mémoire
ob_start();

?>
<h1>Liste</h1>
<article>
    <div class="row">
        <div class="col-lg-8">
            <p class="textModif"><?php
                if(isset($_SESSION['modif']))
                {
                    echo $_SESSION['modif'];
                    echo $_SESSION['modif']="";
                }?>
            <?php require 'vue/code_source/vue_code_source_liste.php';?>
        </div>
</article>
<hr/>
<?php
$contenu = ob_get_clean();
require 'vue/gabarit.php';
?>


