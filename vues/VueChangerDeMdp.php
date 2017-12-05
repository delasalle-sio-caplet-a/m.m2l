<?php
    // Projet Réservations M2L - version web mobile
    // fichier : vues/VueChangerDeMdp.php
    // Rôle : visualiser la liste des réservations à venir d'un utilisateur
    // cette vue est appelée par le contôleur controleurs/CtrlChangerDeMdp.php
    // Création : 07/11/2017 par JM CARTRON
    // Mise à jour : 21/11/2017 par JM CARTRON
?>
<!doctype html>
<html>
	<head>
		<?php include_once ('vues/head.php'); ?>
		
		<script>
			// associe une fonction à l'événement pageinit
			$(document).bind('pageinit', function() {
				<?php if ($typeMessage != '') { ?>
					// affiche la boîte de dialogue 'affichage_message'
					$.mobile.changePage('#affichage_message', {transition: "<?php echo $transition; ?>"});
				<?php } ?>
			} );
		</script>
	</head>
	 
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="<?php echo $themeNormal; ?>">
				<h4>M2L-GRR</h4>
				<a href="index.php?action=Menu" data-transition="<?php echo $transition; ?>">Retour menu</a>
			</div>
			
			<div data-role="content">
				<h4 style="text-align: center; margin-top: 0px; margin-bottom: 0px;">Modifier mon mot de passe</h4>
				<form action="index.php?action=ChangerDeMdp" method="post" data-ajax="false">
					<div data-role="fieldcontain" class="ui-hide-label">
						<label for="txtMdp">Nouveau mot de passe :</label>
						<input type="text" name="txtMdp" id="txtMdp" required placeholder="Mon nouveau mot de passe" value="<?php echo $mdp; ?>">
					</div>
					<div data-role="fieldcontain" class="ui-hide-label">
						<label for="txtConfirmation">Confirmation nouveau mot de passe :</label>
						<input type="text" name="txtConfirmation" id="txtConfirmation" required placeholder="Confirmation de mon nouveau mot de passe" value="<?php echo $confirmation; ?>">
					</div>
					<div data-role="fieldcontain">
						<input type="submit" name="btnEnvoyerdonnees" id="btnEnvoyerdonnees" value="Envoyer les données" data-mini="true">
					</div>
				</form>
			</div>
			
			<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeNormal;?>">
				<h4>Suivi des réservations de salles<br>Maison des ligues de Lorraine (M2L)</h4>
			</div>
		</div>
		
		<?php include_once ('vues/dialog_message.php'); ?>
		
	</body>
</html>