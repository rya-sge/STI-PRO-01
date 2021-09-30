<?php
// vue_algorithmen_contribution.php
// Date de création : 08/01/20121
// Fonction : vue pour afficher les algorithmes d'un utilisateur donné
// __________________________________________
?>
<h2>Algorithme</h2>
<table class="table table-bordered">
    <tr>
        <th>Nom</th>
        <th>Tag</th>
        <th>Présentation</th>
        <th>Date d'ajout</th>
        <th>Dernière modification</th>
        <th>Validation</th>
        <th>Action</th>
    </tr>
    <?php
    //Affiche la liste des Algorithmes d'un utilisateur
    foreach ($algorithmeUnique as $resultat) {
        ?>
        <tr>
            <td width="20%">
                <a href='index.php?action=vue_algorithme&qIdAlgorithme=<?= $resultat['id']; ?>'>
                    <?php echo $resultat['nom']; ?>
                </a>
            </td>
            <td width="20%"><?php echo $resultat['tag']; ?></td>
            <td width="20%"><?php echo $resultat['presentation']; ?></td>
            <td width="20%"><?php echo $resultat['dateAjout']; ?></td>
            <td width="20"><?php echo $resultat['dateModification']; ?></td>
            <td width="20%"><?php echo $resultat['estValide'] ? VALIDE : NON_VALIDE; ?></td>
            <td width="20%">
                <a href="index.php?action=vue_mes_algorithme_suppression&qIdAlgorithme=<?= $resultat['id']; ?>"
                   onclick="return confirm('Etes-vous sûr de vouloir supprimer cet algorithme?');">
                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                        <span class="glyphicon glyphicon-trash"></span></button>
                </a>
            </td> <!--Source : https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_ref_glyph_edit&stacked=h -->
        </tr>
    <?php }
    ?>
</table>