<?php
// ce fichier est destinÃ© Ã  Ãªtre inclus dans les pages PHP qui ont besoin de se connecter Ã  la base mrbs de GRR
// 2 possibilitÃ©s pour inclure ce fichier :
//     include_once ('include_parametres.php');
//     require_once ('include_parametres.php');

// paramÃ¨tres de connexion -----------------------------------------------------------------------------------
global $PARAM_HOTE, $PARAM_PORT, $PARAM_BDD, $PARAM_USER, $PARAM_PWD;
$PARAM_HOTE = "localhost";		// si le sgbd est sur la mÃªme machine que le serveur php
$PARAM_PORT = "3306";			// le port utilisÃ© par le serveur MySql
$PARAM_BDD = "mrbs";			// nom de la base de donnÃ©es
$PARAM_USER = "mrbs";			// nom de l'utilisateur
$PARAM_PWD = "mrbs-intra";		// son mot de passe

// Autres paramètres -----------------------------------------------------------------------------------------
global $DELAI_DIGICODE, $ADR_MAIL_EMETTEUR;

// valeur du dÃ©lai (en secondes) pendant lequel le digicode est acceptÃ© avant l'heure de dÃ©but de rÃ©servation
// ou aprÃ¨s l'heure de fin de rÃ©servation
$DELAI_DIGICODE = 3600;			// 3600 sec ou 1 h

// adresse de l'Ã©metteur lors d'un envoi de courriel
$ADR_MAIL_EMETTEUR = "delasalle.sio.eleves@gmail.com";

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces aprÃ¨s la balise de fin de script !!!!!!!!!!!!