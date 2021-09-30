<?php
// ------------------------------------
// getBD()
// Date de création : 02/03/2017
// Fonction : connexion avec le serveur : instancie et renvoie l'objet PDO
// Sortie : $db

function getBD()
{

  // connexion au serveur MySQL et à la BD
  $db = new PDO('mysql:host=localhost; dbname=Spellbook_db','root','');

  // permet d'avoir plus de détails sur les erreurs retournées
   $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return  $db;
}
?>