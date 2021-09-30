<!--
// vue_pseudo_code_validation.php
// Date de création : 11/01/2021
// Fonction : vue pour afficher une liste de pseudo-code à valider
// __________________________________________
-->

<h2>Pseudo-Code</h2>
<table class="table table-bordered">
    <tr>
        <th>Algo associé</th>
        <th>Description</th>
        <th>Date d'ajout</th>
        <th>Dernière modification</th>
        <th>Texte</th>
        <th>Fichier</th>
        <th>Action</th>
    </tr>
    <?php
    //Affiche la liste des Algorithmes d'un utilisateur
    foreach ($pseudoCode as $resultat) {
        ?>
        <tr>
            <td width="20%"><?php echo $resultat['algorithme'];?></td>
            <td width="33%"><?php echo $resultat['description']; ?></td>
            <td width="20%"><?php echo $resultat['dateAjout']; ?></td>
            <td width="33%"><?php echo $resultat['dateModification']; ?></td>
            <td width="33%"><?php if (!empty($resultat['texte'])){ ?>
                <a href="index.php?action=vue_pseudo_code_texte&qIdPseudoCode=<?= $resultat['id']; ?>"
                   class="btn btn-secondary btn-xs enabled" role="button">Lien</a></td>
            <?php } ?> </td>

            <td width="33%"> <?php if ($resultat['fichier'] != "") { ?>
                    <a href="index.php?action=vue_pseudo_code_telechargement&idPseudoCode=<?= $resultat['id']; ?>">
                        <button class="btn btn-primary btn-xs" data-title="Telecharger" data-toggle="modal"
                                data-target="#download"><span class="glyphicon glyphicon-download-alt"></span></button>
                    </a>
                <?php } ?></td>
            <td width="33%">
                <a href="index.php?action=vue_artefact_validation&qIdArtefact=<?= $resultat['id']; ?>"
                   onclick="return confirm(MSG_VALIDATION);">
                    <button class="btn btn-success btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit">
                        <span class="glyphicon glyphicon-ok"></span></button>
                </a>
                <a href="index.php?action=vue_artefact_validation_supp&qIdArtefact=<?= $resultat['id']; ?>"
                   onclick="return confirm(MSG_SUPPRESSION);">
                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                        <span class="glyphicon glyphicon-remove"></span></button>
                </a>
            </td> <!--https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_ref_glyph_edit&stacked=h --></td>
        </tr>
    <?php }
    ?>
</table>
