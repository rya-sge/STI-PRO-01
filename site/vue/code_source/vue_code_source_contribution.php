<?php
// vue_code_source_liste.php
// Date de création : 15/01/2021
// Fonction : vue pour afficher une liste de code source
// __________________________________________
?>
<h2>Code source</h2>
<table class="table table-bordered">
    <tr>
        <th>Algo associé</th>
        <th>Description</th>
        <th>Date d'ajout</th>
        <th>Dernière modification</th>
        <th>Documentation</th>
        <th>Archive</th>
        <th>Validation</th>
        <th>Action</th>
        <th>Note moyenne</th>
    </tr>
    <?php
    //Affiche la liste des code sources d'un utilisateur
    foreach ($codeSource as $resultat)
    {
        ?>
        <tr>
            <td width="20%"><?php echo $resultat['algorithme'];?></td>
            <td width="33%"><?php echo $resultat['description'];?></td>
            <td width="20%"><?php echo $resultat['dateAjout'];?></td>
            <td width="20%"><?php echo $resultat['dateModification'];?></td>
            <td width="33%">
            <?php if(!empty($resultat['documentation'])) { ?>
                <a href="index.php?action=vue_code_source_telechargement_doc&idCodeSource=<?=$resultat['id']; ?>">Télécharger</a></td>
            <?php } ?>
            <td width="33%">
                <a href="index.php?action=vue_code_source_telechargement_archive&idCodeSource=<?=$resultat['id']; ?>">Télécharger</a></td>
            <td width="33%"><?php echo $resultat['estValide'] ? VALIDE : NON_VALIDE; ?></td>
            <td width="33%">
                <a href="index.php?action=vue_mes_code_source_modification&qIdCodeSource=<?=$resultat['id']; ?>">
                    <button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></a>
                <a href="index.php?action=vue_mes_artefact_suppression&qIdArtefact=<?=$resultat['id']; ?>"
                   onclick="return confirm('Etes-vous sûr de vouloir supprimer ce code source ?');">
                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete"  ><span class="glyphicon glyphicon-trash"></span></button></a>
            </td> <!--https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_ref_glyph_edit&stacked=h --></td>
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