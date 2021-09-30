<!--
// vue_pseudo_code_liste.php
// Date de création : 15/01/2021
// Fonction : vue pour afficher une liste de pseudo-code
// __________________________________________
-->

<h2>Pseudo-Code</h2>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Algo associé</th>
        <th>Description</th>
        <th>Date d'ajout</th>
        <th>Dernière modification</th>
        <th>Texte/Fichier</th>
        <?php if (testR2()) { ?>
            <th>Action</th>
        <?php } ?>
        <th>Note moyenne</th>
        <th>Noter</th>
    </tr>
    <?php
    //Affiche la liste des Algorithmes d'un utilisateur
    foreach ($pseudoCode as $resultat) {
        ?>
        <tr>
            <td width="10%"><?php echo $resultat['id']; ?></td>
            <td width="20%"><?php echo $resultat['algorithme'];?></td>
            <td width="40%"><?php echo $resultat['description']; ?></td>
            <td width="20%"><?php echo $resultat['dateAjout']; ?></td>
            <td width="20%"><?php echo $resultat['dateModification']; ?></td>
            <td width="20%">
                <?php if ($resultat['fichier'] != ""){ ?>
                    <a href="index.php?action=vue_pseudo_code_telechargement&idPseudoCode=<?= $resultat['id']; ?>"
                    class="btn btn-secondary btn-xs enabled" role="button">Lien (F)</a>
                <?php }
                    else { ?>
                    <a href="index.php?action=vue_pseudo_code_texte&qIdPseudoCode=<?= $resultat['id']; ?>"
                    class="btn btn-secondary btn-xs enabled" role="button">Lien (T)</a>
                    <?php }?>
            </td>
            <?php if (testR2()) { ?>
                <td width="20%">
                    <a href="index.php?action=vue_artefact_suppression&qIdArtefact=<?= $resultat['id']; ?>"
                       onclick="return confirm('Etes-vous sûr de vouloir supprimer ce pseudo-code ?');">
                        <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                            <span class="glyphicon glyphicon-trash"></span></button>
                    </a>
                </td>
            <?php } ?>
            <!--https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_ref_glyph_edit&stacked=h --></td>
            <?php if (isset($resultat['note_moyenne'])) { ?>
                <td width="20%">
                    <?php echo $resultat['note_moyenne']; ?>
                </td>
            <?php } else { ?>
                <td width="20%"><?php echo "-" ?></td>
            <?php } ?>
            <?php if(isset($estUnAlgo)){
                $dest = "index.php?action=vue_artefact_algorithme_note&qIdArtefact=".$resultat['id'];
            }else{
                $dest = "index.php?action=vue_pseudo_code_liste_note&qIdArtefact=".$resultat['id'];
            }?>
            <td width="20%">
                <form class='form' method='POST' action="<?php echo $dest ?>"
                      enctype="multipart/form-data">
                    <?php require 'vue/note/vue_select_note.php'; ?>
                    <button type="submit" class="btn btn-primary" name="ajouterNote">Envoyer</button>
                </form>
            </td>
        </tr>
    <?php }
    ?>
</table>
