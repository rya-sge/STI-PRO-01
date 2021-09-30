<?php
  $titre ='TheDeveloperSpellbook - Profil utilisateur';

// vue_profil.php
// Date de création : 24/12/2020
// Fonction : vue pour afficher le  profil de l'utilisateur, qui contient ses informations personnelles.
// __________________________________________

// Tampon de flux stocké en mémoire
ob_start();
?>
	
<?php

?>
<p class="textModif"><?php
	if(isset($_SESSION['modif']))
	{
		echo $_SESSION['modif'];
		echo $_SESSION['modif']="";
	}?>
	</p>
<div id="profil">
	<h1>PROFIL</h1>
	<p>Bonjour <?php echo $_SESSION['login']; ?> ! Vous trouvrez ici vos informations de compte. </p>
	<table class="table table-bordered" >
		<thead>
			<tr>
				<th colspan=2 style="width:50; text-align:center"  >Infomations de compte</th>
					<!--<form action="index.php?action=vue_profil" method="Post" >-->
				<th style="width:20%">Action</th>
					<!--<input class ="btn btn-primary" type="submit" name="fNProfil" value="modifier"></input>
				</th>-->
				<!--Ce formulaire permet d'aller sur la page d'édition des informations de compte -->		
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Nom d'utilisateur</td>
				<td><?php echo $_SESSION['login']; ?></td>
				<td><a href="index.php?action=vue_profil_login_upd"><button class="btn btn-primary btn-xs" ><span class="glyphicon glyphicon-pencil"></span></button></a></td>

			</tr>
			<tr>
			<td>Mot de passe</td>
			<td></td>
			<td><a href="index.php?action=vue_profil_passwd_modif"><button class="btn btn-primary btn-xs" ><span class="glyphicon glyphicon-pencil"></span></button></a></td>
			</tr>
			<tr>
				<td>Adresse email</td>
				<td><?php echo $infoUser['email'];?></td>
				<td><a href="index.php?action=vue_profil_email_upd"><button class="btn btn-primary btn-xs" ><span class="glyphicon glyphicon-pencil"></span></button></a></td>
			</tr>
			<tr>
				<td>Etat du compte</td>
				<td>Actif</td>
				<td><a href="index.php?action=vue_profil_del"><button class="btn btn-danger" >Supprimer le compte</button></a></td>
			</tr>
		<tbody>
	</table>
</div>
  <?php
    $contenu = ob_get_clean();
    require "vue/gabarit_visiteur.php";
?>