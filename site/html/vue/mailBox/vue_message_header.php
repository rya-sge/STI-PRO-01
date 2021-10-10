<table>
    <th>Action</th>
    <tr>
        <th>Date de réception</th>
        <td width="20%"><?php echo $resultat['dateReceipt'];?></td>
    </tr>
    <tr>
        <th>Expéditeur</th>
        <td width="40%"><?php echo $resultat['name']; ?></td>
    </tr>
    <tr>
    <th>Sujet</th>

        <td width="20%"><?php echo $resultat['subject']; ?></td>
        <td width="20%">
            <a href="index.php?action=vue_inbox_delete&qIdMessage=<?= $resultat['id']; ?>"
               onclick="return confirm('Etes-vous sûr de vouloir supprimer ce message ?');">
                <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                    <span class="glyphicon glyphicon-trash"></span></button>
            </a>
        </td>
    </tr>
</table>
