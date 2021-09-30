<?php
  $titre ='TheDeveloperSpellbook - erreur';

// vue_erreur.php
// Date de création : 24/12/2020
// Fonction : vue pour l'affichage des erreurs si l'utilisateur  est connecté
// __________________________________________

// Tampon de flux stocké en mémoire
ob_start();
?>

<article>
  <header>
      <!-- <h2> Erreur </h2>-->
    <!--<p>L'action demandée est inconnue !</p>-->
    <?/*=@$_SESSION['erreur'];*/?>
  </header>
</article>
<hr/>

<?php 
  $contenu = ob_get_clean();
  require 'vue/gabarit.php';
?>  
      
      
      