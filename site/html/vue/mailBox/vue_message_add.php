<?php
$titre = 'SpellBook - Ajouter un boiteMail';

// vue_message_add.php
// Date de création : 10/01/2021
// Fonction : vue pour ajouter un boiteMail
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
                <legend>Ecrire un message</legend>
            </h2>
            <form class='form' method='POST' action="index.php?action=vue_message_add">
                <div class="form-group">
                    <label>Destinataire*</label>
                    <input class="form-control" type="text" placeholder="Entrez le nom du destinataire" name="recipient"
                           value="<?= @$_POST['recipient'] ?>" required/>
                    </br>
                    <label>Sujet</label>
                    <input class="form-control" type="text" placeholder="Entrez le sujets" name="subject"
                           value="<?= @$_POST['subject'] ?>"/>
                    </br>
                    <label>Corps</label>
                    <textarea class="form-control"  rows="3"
                              placeholder="Entrez le texte de l'email" name="body"
                              value="<?= @$_POST['body'] ?>"> </textarea>
                    </br>
                    <!--Source : https://html5-tutorial.net/forms/checkboxes/ -->
                    </br>
                    <button type="submit" class="btn btn-primary" name="addMessage">Envoyer le message</button>
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


