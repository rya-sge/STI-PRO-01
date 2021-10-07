<tr>
    <td width="20%"><?php echo $resultat['id'];?></td>
    <td width="20%"><?php echo $resultat['dateReceipt'];?></td>
    <td width="20"><?php echo $resultat['sender']; ?></td>
    <td width="20%"><?php echo $resultat['subject']; ?></td>
    <td>
        <a href="index.php?action=vue_inbox_delete&qIdMessage=<?= $resultat['id']; ?>"
           onclick="return confirm('Etes-vous sûr de vouloir supprimer ce message ?');">del
        </a>
        <a href="index.php?action=vue_message_read&qIdMessage=<?= $resultat['id'];?>" >test
        </a>

    </td>
</tr>




