<tr>
    <td width="10%"><?php echo $resultat['id']; ?></td>
    <td width="20%"><?php echo $resultat['dateReceipt'];?></td>
    <td width="40%"><?php echo $resultat['sender']; ?></td>
    <td width="20%"><?php echo $resultat['subject']; ?></td>
    <td width="20%">
        <a href="index.php?action=vue_inbox_delete&qIdMessage=<?= $resultat['id']; ?>"
           onclick="return confirm('Etes-vous sûr de vouloir supprimer ce message ?');">
            <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                <span class="glyphicon glyphicon-trash"></span></button>
        </a>
        <a href="index.php?action=vue_message_read&qIdMessage=<?= $resultat['id']; ?>">
            <button class="btn btn-danger btn-xs" data-title="Delete" data-toggle="modal" data-target="#delete">
                <span class="glyphicon glyphicon-trash"></span></button>
        </a>
    </td>

</tr>
