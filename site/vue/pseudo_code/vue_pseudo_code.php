<?php
// vue_pseudo_code.php
// Date de création : 09/01/2021
// Fonction : vue pour afficher une liste de pseudo-code
// __________________________________________

$titre ='TheDeveloperSpellbook - Gestion des pseudo-codes';

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
                <?php require 'vue/pseudo_code/vue_pseudo_code_liste.php';?>
        </div>
</article>
<hr/>
<?php
$contenu = ob_get_clean();
require 'vue/gabarit.php';
?>


