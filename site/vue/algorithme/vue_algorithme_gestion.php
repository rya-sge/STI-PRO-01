<?php
// vue_algorithme_gestion.php
// Date de création : 08/01/20121
// Fonction : vue pour afficher l'ensemble des algorithmes du site
// __________________________________________

$titre = 'SpellBook - Gestion des algorithmes';
// Tampon de flux stocké en mémoire
ob_start();

?>
<p class="textModif"><?php
    if (isset($_SESSION['modif'])) {
        echo $_SESSION['modif'];
        echo $_SESSION['modif'] = "";
    } ?>
</p>
<h2>Liste des algorithmes présents sur le site

    <a href='index.php?action=vue_algorithme_add'>
        <button type='button' class='btn btn-primary'><strong>Ajouter un algorithme</strong></button>
    </a>

</h2>
<article>
    <div class="row">
        <div class="col-lg-8">
            <?php
            require 'vue/algorithme/vue_algorithme_recherche.php'; ?>
            <?php require 'vue/algorithme/vue_algorithme_gestion_page.php'; ?>
        </div>
    </div>
</article>
<hr/>
<?php
$contenu = ob_get_clean();
require 'vue/gabarit.php';
?>


