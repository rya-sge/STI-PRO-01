<?php
// vue_algorithme_validation.php
// Date de création : 15/01/20121
// Fonction : vue pour afficher les algorithmes en attente de validation
// __________________________________________
?>
<h2>Algorithme</h2>
            <table class="table table-bordered">
                <tr>
                    <th>Nom</th>
                    <th>Présentation</th>
                    <th>Tag</th>
                    <th>Date d'ajout</th>
                    <th>Dernière modification</th>
                    <th>Action</th>
                </tr>
                <?php

                //Affiche la liste des Algorithmes non validés
                foreach ($algorithmeUnique as $resultat)
                {
                    ?>

                    <tr id="<?php echo $resultat['nom'] ?>">
                        <td width="20%"><?php echo $resultat['nom'];?></td>
                        <td width="33%"><?php echo $resultat['presentation'];?></td>
                        <td width="33%"><?php echo $resultat['tag'];?></td>
                        <td width="33%"><?php echo $resultat['dateAjout'];?></td>
                        <td width="33%"><?php echo $resultat['dateModification'];?></td>
                        <td width="33%">
                            <a href="index.php?action=vue_algorithme_validation&qIdAlgorithme=<?=$resultat['id']; ?>" onclick="return confirm(MSG_VALIDATION);"><button class="btn btn-success btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-ok"></span></button></a>
                            <a href="index.php?action=vue_algorithme_validation_supp&qIdAlgorithme=<?=$resultat['id']; ?>" onclick="return confirm(MSG_SUPPRESSION);"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete"  ><span class="glyphicon glyphicon-remove"></span></button></a>
                        </td> <!--https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_ref_glyph_edit&stacked=h --></td>
                    </tr>
                <?php }
                ?>
            </table>