<?php
// vue_inbox.php
// Date de création : 03/10/20121
// Fonction : vue pour afficher l'ensemble des messages d'un utilisateur
// __________________________________________


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
                <?php require 'vue/mailBox/vue_inbox_list.php';?>
        </div>
</article>
<hr/>
<?php
$contenu = ob_get_clean();
require 'vue/gabarit.php';
?>


