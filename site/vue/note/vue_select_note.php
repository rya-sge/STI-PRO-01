<!--
// vue_select_note.php
// Date de création : 17/01/2021
// Fonction : vue contenant les balises select pour noter un code source ou pseudo-code
// __________________________________________
-->
<select  name="note">
    <option type ="hidden" value="NO_VALUE" selected></option>
    <?php
    foreach (range(0, 10) as $number) {
        ?>  <option value="<?php echo $number?>"><?php echo $number?></option>
    <?php } ?>
</select>
