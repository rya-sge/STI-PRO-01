<?php
$titre ='TheDeveloperSpellbook - Modifier un code source';

// vue_code_source_upd.php
// Date de création : 16/01/2021
// Fonction : vue pour modifier un code source
// __________________________________________

// Tampon de flux stocké en mémoire
ob_start();

?>
<p class="textModif"><?php
    if(isset($_SESSION['modif']))
    {
        echo $_SESSION['modif'];
        echo $_SESSION['modif']="";
    }?>
</p>
<h2>Modifier un code source</h2>

<article>
    </br>
    <fieldset>
        <!--<legend></legend>-->
        <form class='form' method='POST' action="index.php?action=vue_mes_code_source_modification" enctype="multipart/form-data">
            <div class="form-group">
                <label>Description</label>
                <input class="form-control" type="text" placeholder="Entrez sa description" name="description" value="<?= $infoCodeSource['description']; ?>"/>
            </div>
            <div class="form-group">
                <label for="langage">Selectionner un langage de programmation</label>
                <select class="form-control"  name ="idLangage" id = "langage">
                    <?php
                    //Affiche la liste des  langages
                    foreach ($langages as $resultat)
                    {
                        echo "<option value = '".$resultat['id']."'>".$resultat['nom']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label>Archive* </label>
                <label>Selectionner votre fichier* </label>
                (extension autorisée : .zip,.tar, .rar, .7z)
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
                <input type="file" name = "fichierCodeSource" accept=".zip, .tar, .rar, .7z" />
            </div>
            <div class="form-group">
                <label>Documentation </label>
                <label>Selectionner votre fichier* </label>
                (extension autorisée : .doc,.docx, .odt, .pdf, .zip,.tar, .rar, .7z, .txt)
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
                <input type="file" name="fichierDocumentation" accept=".doc,.docx, .odt, .pdf, .zip,.tar, .rar, .7z, .txt"/>
            </div>
            <button type="submit" class="btn btn-primary" name="modifierCodeSource">Modifier le document</button>
            <button type="reset" class="btn btn-primary">Effacer</button>
            <a href='index.php?action=vue_contribution_gestion'>
                <button type='button' class='btn btn-primary'  >Revenir à la gestion de vos contribution</button> </a>
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


