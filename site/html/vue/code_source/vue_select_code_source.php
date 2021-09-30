<!--
// vue_select_note.php
// Date de création : 17/01/2021
// Fonction : vue contenant les balises select pour noter un code source ou pseudo-code
// __________________________________________
-->
<select  name="idPseudoCode">
    <option type ="hidden" value="NO_VALUE" selected></option>
    <?php
    foreach ($pseudoCode as $choix) {
        ?>  <option value="<?php echo $choix["id"]?>"><?php echo $choix["id"]?></option>
    <?php } ?>
</select>

