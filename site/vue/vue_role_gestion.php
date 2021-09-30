<?php
$titre = 'TheDeveloperSpellbook - Liste des utilisateurs';

// vue_role_gestion.php
// Date de création : 09/01/2021
// Fonction : vue pour gérer les rôles des utilisateurs sur le site
// __________________________________________

// Tampon de flux stocké en mémoire
ob_start();

?>
<h2>Gestion des rôles des utilisateurs
    <a href='index.php?action=vue_moderateur_ajout'>
        <button type='button' class='btn btn-primary'><strong>Ajouter un modérateur</strong></button>
    </a>
</h2>
<p class="textModif"><?php
    if (isset($_SESSION['modif'])) {
        echo $_SESSION['modif'];
        echo $_SESSION['modif'] = "";
    } ?>
</p>

<article>
    <div class="row">
        <div class="col-lg-8"> <!--Source : https://www.w3schools.com/bootstrap/bootstrap_tables.asp  -->
            <table class="table table-bordered">
                <tr>
                    <th>Id</th>
                    <th>Nom d'utilisateur</th>
                    <th>Action</th>
                </tr>
                <?php
                //Affiche la liste des comptes avec leur catégorie
                foreach ($resultats as $resultat) {
                    ?>
                    <tr>
                        <td width="20%"><?php echo $resultat['id']; ?></td>
                        <td width="33%"><?php echo $resultat['nom']; ?></td>
                        <td width="33%">
                            <a href="index.php?action=vue_moderateur_suppression&qIdUtilisateur=<?= $resultat['id']; ?>"
                               onclick="return confirm('Etes-vous sûr de vouloir supprimer ce modérateur');">
                                <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal"
                                        data-target="#delete"><span class="glyphicon glyphicon-trash"></span>
                                </button>
                            </a>
                        </td>
                    </tr>
                <?php }
                ?>
            </table>
        </div>
</article>
<hr/>
<?php
$contenu = ob_get_clean();
require 'gabarit.php';
?>


