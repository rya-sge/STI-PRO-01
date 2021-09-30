<?php
$titre ='TheDeveloperSpellbook - Ajouter un pseudo_code';

// vue_pseudo_code_add.php
// Date de création : 10/01/2021
// Fonction : vue pour ajouter un pseudo-code
// __________________________________________

// Tampon de flux stocké en mémoire
ob_start();

?>
<script src="https://cdn.tiny.cloud/1/824256qsbvrdfm8krhft7kjhr3iynxwdtpc99zwx6c421amv/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

<p class="textModif"><?php
    if(isset($_SESSION['modif']))
    {
        echo $_SESSION['modif'];
        echo $_SESSION['modif']="";
    }?>
</p>
<h2>Ajouter un pseudo-code</h2>
<article>
    </br>
    <fieldset>
        <label>Type de pseudo-code</label>
        <ul class="nav nav-pills">

            <li class="active">
                <a href="#addFromFile" class="btn btn btn-outline-primary" data-toggle="tab">Importer un fichier</a>
            </li>
            <li><a href="#addFromText" class="btn btn-outline-primary" data-toggle="tab">Ecrire ici</a>
            </li>
        </ul>
        </br>
        <div class="tab-content clearfix">
            <div class="input-group tab-pane active" id="addFromFile">


        <form class='form' method='POST' action="index.php?action=vue_pseudo_code_ajout" enctype="multipart/form-data">

            <div class="form-group">
                <label>Description</label>
                <input class="form-control" type="text" placeholder="Entrez sa description" name="description" value="<?=@$_POST['description'] ?>" required/>
                </br>
            </div>
            <div class="form-group">
                <label>Selectionner un fichier </label>
                (extension autorisée : .doc,.docx, .odt, .pdf, .zip, .tar.gz, .rar, .7z, .txt)
                <input type="hidden" name="MAX_FILE_SIZE" value="1000000000">
                <input type="file" name = "fichierPseudoCode"  accept=".doc, .docx, .odt, .pdf, .zip, .tar.gz, .rar, .7z, .txt" required/>
                </br></br>
                <button type="submit" class="btn btn-primary" name="ajouterPseudoCode">Envoyer</button>
            </div>
        </form>

            </div>
            <div class="card tab-pane" id="addFromText">
                <form class='form' method='POST' action="index.php?action=vue_pseudo_code_ajout" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Description</label>
                        <input class="form-control" type="text" placeholder="Entrez sa description" name="description" value="<?=@$_POST['description'] ?>" required/>
                    </div>
                    <div class="form-group">
                        <script>
                            tinymce.init({
                                selector: '#txtDescription'
                            });
                        </script>
                        <textarea name ="textePseudoCode" id="txtDescription"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary" name="ajouterPseudoCode">Envoyer</button
                </form>
            </div>

        </div>
    </fieldset>
    </br>

    <a href='index.php?action=vue_algorithme_gestion'>
        <button type='button' class='btn btn-primary' >Revenir à la gestion des algorithmes</button>
    </a>
    </br>
    </div>
</article>
<hr/>
<?php
$contenu = ob_get_clean();
require 'vue/gabarit.php';
?>


