<?php
$titre ='TheDeveloperSpellbook - Ajouter un code source';

// vue_pseudo_code_add.php
// Date de création : 09/01/2021
// Fonction : vue pour ajouter un codes sources
// __________________________________________

// Tampon de flux stocké en mémoire
ob_start();

?>
<p class="textModif"><?php
    if (isset($_SESSION['modif'])) {
        echo $_SESSION['modif'];
        echo $_SESSION['modif'] = "";
    } ?>
</p>
<h2>Ajouter un code source</h2>

<article>
    </br>
    <fieldset>
        <!--<legend></legend>-->
        <form class='form' method='POST' action="index.php?action=vue_code_source_ajout" enctype="multipart/form-data">
            <div class="form-group">
                <label>Description</label>
                <input class="form-control" type="text" placeholder="Entrez sa description" name="description"
                       value="<?= @$_POST['description'] ?>"/>
            </div>
            <div class="form-group">
                <label for="langage">Selectionner un langage de programmation</label>
                <select class="form-control" name="idLangage" id="langage">
                    <?php
                    //Affiche la liste des  langages
                    foreach ($resultats as $resultat) {
                        echo "<option value = '" . $resultat['id'] . "'>" . $resultat['nom'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Archive* </label>
                (extension autorisée : .zip, .tar.gz, .rar, .7z)
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
                <input type="file" name="fichierCodeSource" accept=".zip, .tar.gz, .rar, .7z" required/>
            </div>
            <div class="form-group">
                <label>Documentation</label>
                (extension autorisée : .doc,.docx, .odt, .pdf, .zip, .tar.gz , .rar, .7z, .txt)
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
                <input type="file" name="fichierDocumentation"
                       accept=".doc,.docx, .odt, .pdf, .zip, .tar.gz, .rar, .7z, .txt"/>
            </div>
            <button type="submit" class="btn btn-primary" name="ajouterCodeSource">Ajouter le document</button>
            <button type="reset" class="btn btn-primary">Effacer</button>
            <a href='index.php?action=vue_algorithme_gestion'>
                <button type='button' class='btn btn-primary'>Revenir à la gestion des algorithmes</button>
            </a>
        </form>
    </fieldset>
    </br>
    </div>
</article>
<hr/>
<?php
$contenu = ob_get_clean();
require 'vue/gabarit.php';
?>


