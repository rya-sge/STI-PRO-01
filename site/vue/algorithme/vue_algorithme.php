<?php
// vue_algorithme.php
// Date de création : 08/01/20121
// Fonction : vue pour afficher un algorithme
// __________________________________________

$titre ='SpellBook - Page d\'un Algorithme';
// Tampon de flux stocké en mémoire
ob_start();

?>
<h2>Page de l'algorithme

    <a href='index.php?action=vue_code_source_ajout'>
        <button type='button' class='btn btn-primary'  ><strong>Ajouter un code source</strong></button>
    </a>
    <a href='index.php?action=vue_pseudo_code_ajout'>
        <button type='button' class='btn btn-primary'  ><strong>Ajouter un pseudo code</strong></button>
    </a>
</h2>
<h3>Présentation</h3>
    <p><?php echo $algorithme['presentation']; ?></p>

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
                <?php require 'vue/pseudo_code/vue_pseudo_code_liste.php';?>
        </div>
</article>
<hr/>
<?php
$contenu = ob_get_clean();
require 'vue/gabarit.php';
?>


