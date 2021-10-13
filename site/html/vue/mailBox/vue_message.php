<?php
  $titre ='HashMail-message';

// vue_lieu.php
// Date de création : 07/10/2021
// Auteur : RSA
// Fonction : vue pour afficher les informations d'un lieu en particulier.
// _______________________________

// Tampon de flux stocké en mémoire
ob_start();
?>

<h2>Votre message</h2>

<article>
    <?php require 'vue/mailBox/vue_message_header.php';?>
    <h3>Corps du message</h3>
    <p><?php echo $resultat['body']; ?>
    </p>
</article>
<hr/>
  <?php
    $contenu = ob_get_clean();
    require "vue/gabarit.php";
?>
