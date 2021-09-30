<?php
// vue_algorithme_gestion_page.php
// Date de création : 15/01/20121
// Fonction : vue pour afficher un algorithme donné
// __________________________________________
?>

<h2>Algorithme</h2>

<ul class="nav nav-pills">
    <li class="active">
        <a href="#alltab" class="btn btn-outline-primary" data-toggle="tab">
            Tout afficher
        </a>
    </li>

    <?php foreach ($familles as $famille) {
        $nomSansEspace = str_replace(' ', '', $famille['nom']);
        ?>
        <li>
            <a href="#<?php echo $nomSansEspace ?>tab" class="btn btn-outline-primary" data-toggle="tab">
                <?php echo $famille['nom'] ?>
            </a>
        </li>
    <?php } ?>
</ul>

<br/>

<div class="tab-content clearfix">
    <div class="active card tab-pane" id="alltab">
        <table class="table table-bordered">
            <tr>
                <th>Nom</th>
                <th>Tag</th>
                <th>Date d'ajout</th>
                <th>Dernière modification</th>
                <?php if (testR2()) { ?>
                    <th>Action</th>
                <?php } ?>
            </tr>

            <?php foreach ($algorithmeUnique as $algo) { ?>
                <tr>
                    <td width="20%">
                        <a href='index.php?action=vue_algorithme&qIdAlgorithme=<?= $algo['id']; ?>'>
                            <?php echo $algo['nom']; ?>
                        </a>
                    </td>
                    <td width="20%"><?php echo $algo['tag']; ?></td>
                    <td width="20%"><?php echo $algo['dateAjout']; ?></td>
                    <td width="20"><?php echo $algo['dateModification']; ?></td>
                    <?php if (testR2()) { ?>
                        <td width="20%">
                            <a href="index.php?action=vue_algorithme_suppression&qIdAlgorithme=<?= $algo['id']; ?>"
                               onclick="return confirm('Etes-vous sûr de vouloir supprimer cet algorithme?');">
                                <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal"
                                        data-target="#delete">
                                    <span class="glyphicon glyphicon-trash"></span></button>
                            </a>
                        </td>
                    <?php } ?>
                    <!--Source : https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_ref_glyph_edit&stacked=h -->
                </tr>
            <?php } ?>
        </table>
    </div>

    <?php
    foreach ($familles as $famille) {
        $nomSansEspace = str_replace(' ', '', $famille['nom']);
        ?>
        <div class="card tab-pane" id="<?php echo $nomSansEspace ?>tab">
            <table class="table table-bordered">
                <tr>
                    <th>Nom</th>
                    <th>Tag</th>
                    <th>Date d'ajout</th>
                    <th>Dernière modification</th>
                    <?php if (testR2()) { ?>
                        <th>Action</th>
                    <?php } ?>
                </tr>
                <?php
                foreach ($algorithme as $algo) {
                    if (isset($algo['famille']) && $algo['famille'] == $famille['nom']) { ?>
                        <tr>
                            <td width="20%">
                                <a href='index.php?action=vue_algorithme&qIdAlgorithme=<?= $algo['id']; ?>'>
                                    <?php echo $algo['nom']; ?>
                                </a></td>
                            <td width="20%"><?php echo $algo['tag']; ?></td>
                            <td width="20%"><?php echo $algo['dateAjout']; ?></td>
                            <td width="20"><?php echo $algo['dateModification']; ?></td>

                            <?php if (testR2()) { ?>
                                <td width="20%">
                                <a href="index.php?action=vue_algorithme_suppression&qIdAlgorithme=<?= $algo['id']; ?>"
                                   onclick="return confirm('Etes-vous sûr de vouloir supprimer cet algorithme?');">
                                    <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal"
                                            data-target="#delete">
                                        <span class="glyphicon glyphicon-trash"></span></button>
                                </a>
                                </td><?php } ?>

                            <!--https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_ref_glyph_edit&stacked=h -->

                        </tr>
                    <?php }
                } ?>
            </table>
        </div>
    <?php } ?>
</div>


</table>

