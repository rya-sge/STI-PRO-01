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
        <?php if (testR2()) { ?>
            <th>Action</th>
        <?php } ?>
        <th>Note Moyenne</th>
        <th>Noter</th>
        <?php if(isset($estUnAlgo)) { ?>
            <th>Pseudo-Code</th>
        <?php } ?>
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
            <td width="33%"><?php echo $resultat['dateModification'];?></td>
            <td </td><?php if(!empty($resultat['documentation'])) { ?>
                <a href="index.php?action=vue_code_source_telechargement_doc&idCodeSource=<?=$resultat['id']; ?>">Télécharger</a></td>
            <?php } ?>
            <td width="33%"><a href="index.php?action=vue_code_source_telechargement_archive&idCodeSource=<?=$resultat['id']; ?>">Télécharger</a></td></td>
            <?php if (testR2()) { ?>
            <td width="33%">
                <a href="index.php?action=vue_mes_code_source_modification&qIdCodeSource=<?=$resultat['id']; ?>"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit" ><span class="glyphicon glyphicon-pencil"></span></button></a>
                <a href="index.php?action=vue_artefact_suppression&qIdArtefact=<?=$resultat['id']; ?>"
                   onclick="return confirm('Etes-vous sûr de vouloir supprimer ce code source ?');"><button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete"  ><span class="glyphicon glyphicon-trash"></span></button></a>
            </td> <!--https://www.w3schools.com/bootstrap/tryit.asp?filename=trybs_ref_glyph_edit&stacked=h --></td>
            <?php } ?>
            <?php if (isset($resultat['note_moyenne'])) { ?>
                <td width="20%">
                    <?php echo $resultat['note_moyenne']; ?>
                </td>
            <?php } else { ?>
                <td width="20%"><?php echo "-" ?></td>
            <?php } ?>
            <td width="20%">
                <?php if(isset($estUnAlgo)){
                    $dest = "index.php?action=vue_artefact_algorithme_note&qIdArtefact=".$resultat['id'];
                }else{
                    $dest = "index.php?action=vue_code_source_liste_note&qIdArtefact=".$resultat['id'];
                }?>
                <form class='form' method='POST' action="<?php echo $dest ?>"
                      enctype="multipart/form-data">
                    <?php require 'vue/note/vue_select_note.php'; ?>
                    <button type="submit" class="btn btn-primary" name="ajouterNote">Envoyer</button>
                </form>
            </td>
            <!--SElECT POUR AJOUTER PSEUDO-CODE-->
            <?php if(isset($estUnAlgo)){ ?>
                <td width="20%">
                    <?php if(!$resultat['idPseudoCode']) { ?>
                    <form class='form' method='POST' action="index.php?action=vue_code_source_attacher_pseudo_code"
                          enctype="multipart/form-data">
                        <?php require 'vue/code_source/vue_select_code_source.php'; ?>
                        <input type="hidden" value="<?php echo $resultat['id']?>" name="idCodeSource" >
                        <button type="submit" class="btn btn-primary" name="attacherPseudoCode">Envoyer</button>
                    </form>

                    <?php }
                    else {
                        echo $resultat['idPseudoCode'];
                    } ?>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>
