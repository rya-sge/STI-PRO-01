<!--
// vue_inbox_list.php
// Date de création : 03/10/2021
// Fonction : vue pour afficher la liste des messages reçus
// __________________________________________
-->

<h2>Pseudo-Code</h2>
<table class="table table-bordered">
    <tr>
        <th>ID</th>
        <th>Date de réception</th>
        <th>Expéditeur</th>
        <th>Sujet</th>
        <th>Action</th>
    </tr>
    <?php
    //Affiche la liste des messages d'un utilisateur
    foreach ($message  as $resultat) {
    ?>
             <?php require 'vue/mailBox/vue_message_header.php';?>
    <?php }
    ?>
</table>
