<!--
// vue_pseudo_code_liste.php
// Date de création : 15/01/2021
// Fonction : vue pour afficher une liste de pseudo-code
// __________________________________________
-->

<h2>Pseudo-Code</h2>
<table class="table table-bordered">
    <tr>
        <th>Algo associé</th>
        <th>Description</th>
        <th>Date d'ajout</th>
        <th>Dernière modification</th>
        <th>Texte/Fichier</th>
        <th>Validation</th>
        <th>Action</th>
        <th>Note moyenne</th>
    </tr>
    <?php
    //Affiche la liste des Algorithmes d'un utilisateur
    foreach ($pseudoCode as $resultat) {
        ?>
        <tr>
            <td width="20%"><?php echo $resultat['algorithme'];?></td>
            <td width="40%"><?php echo $resultat['description']; ?></td>
            <td width="20%"><?php echo $resultat['dateAjout']; ?></td>
            <td width="20%"><?php echo $resultat['dateModification']; ?></td>
            <td width="20%">
                <?php if (!empty($resultat['texte'])){ ?>
                <a href="index.php?action=vue_pseudo_code_texte&qIdPseudoCode=<?= $resultat['id']; ?>"
                   class="btn btn-secondary btn-xs enabled" role="button">Lien (T)</a></td>
            <?php } else { ?>
                <a href="index.php?action=vue_pseudo_code_telechargement&idPseudoCode=<?= $resultat['id']; ?>"
                   class="btn btn-secondary btn-xs enabled" role="button">Lien (F)</a></td>
            <?php }?>
            <td width="33%"><?php echo $resultat['estValide'] ? VALIDE : NON_VALIDE; ?></td>
            <td width="20%">
                <a href="index.php?action=vue_mes_artefact_suppression&qIdArtefact=<?= $resultat['id']; ?>"
                   onclick="return confirm('Etes-vous sûr de vouloir supprimer ce pseudo-code ?');">
                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                        <span class="glyphicon glyphicon-trash"></span></button>
                </a>
            </td>
            <!--https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_ref_glyph_edit&stacked=h --></td>
            <?php if (isset($resultat['note_moyenne'])) { ?>
                <td width="20%">
                    <?php echo $resultat['note_moyenne']; ?>
                </td>
            <?php } else { ?>
                <td width="20%"><?php echo "-" ?></td>
            <?php } ?>
        </tr>
    <?php }
    ?>
</table>
