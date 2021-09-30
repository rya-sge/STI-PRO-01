<?php
$titre = 'SpellBook - Ajouter un algorithme';

// vue_algorithme_add.php
// Date de création : 10/01/2021
// Fonction : vue pour ajouter un algorithme
// __________________________________________

// Tampon de flux stocké en mémoire
ob_start();

?>
<p class="textModif"><?php
    if(isset($_SESSION['modif']))
    {
        echo $_SESSION['modif'];
        $_SESSION['modif'] = "";
    }?>
</p>
<article>
    </br>
    <div id="profil">
        <fieldset>
            <h2>
                <legend>Ajouter un algorithme</legend>
            </h2>
            <form class='form' method='POST' action="index.php?action=vue_algorithme_add">
                <div class="form-group">
                    <label>Nom*</label>
                    <input class="form-control" type="text" placeholder="Entrez le nom de l'algorithme'" name="nom"
                           value="<?= @$_POST['tag'] ?>" required/>
                    </br>
                    <label>Tag</label>
                    <input class="form-control" type="text" placeholder="Entrez les tags" name="tag"
                           value="<?= @$_POST['tag'] ?>"/>
                    </br>
                    <label>Présentation</label>
                    <input class="form-control" type="text" placeholder="Entrez une présentation" name="presentation"
                           value="<?= @$_POST['presentation'] ?>"/>
                    </br>
                    <!--Source : https://html5-tutorial.net/forms/checkboxes/ -->
                    <fieldset>
                        <legend>Sélectionner une ou des famille(s)</legend>
                        <?php foreach ($famille as $resultat){ ?>
                            <div>
                            <input type="checkbox"   value = "<?php echo $resultat['id'] ?>"  name = "idFamille[]">
                            <label
                                for ="<?php echo $resultat['nom']; ?>"><?php echo $resultat['nom']; ?>
                            </label>
                            </div>
                        <?php } ?>
                    </fieldset>
                    </br>
                    <button type="submit" class="btn btn-primary" name="AjoutAlgorithme">Ajouter l'algorithme</button>
                    <button type="reset" class="btn btn-primary">Effacer</button>
                </div>
            </form>
        </fieldset>
        </br>
        <fieldset>

    </div>
</article>
<hr/>
<?php
$contenu = ob_get_clean();
require 'vue/gabarit.php';
?>


