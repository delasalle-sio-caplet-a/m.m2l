<?php
// Projet Réservations M2L - version web mobile
// fichier : controleurs/CtrlCreerUtilisateur.php
// Rôle : traiter la demande de création d'un nouvel utilisateur
// Création : 21/10/2015 par JM CARTRON
// Mise à jour : 2/6/2016 par JM CARTRON

// on vérifie si le demandeur de cette action a le niveau administrateur
    if ( ! isset ($_POST ["txtName"]) ) {
        // si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
        $name = '';
        $message = '';
        $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
        $themeFooter = $themeNormal;
        include_once ('vues/VueDemanderMdp.php');
    }
    else {
        // récupération des données postées
        if ( empty ($_POST ["txtName"]) == true)  $name = "";  else   $name = $_POST ["txtName"];
        
        if ($name == '') {
            // si les données sont incorrectes ou incomplètes, réaffichage de la vue de suppression avec un message explicatif
            $message = 'Données incomplètes ou incorrectes !';
            $typeMessage = 'avertissement';
            $themeFooter = $themeProbleme;
            include_once ('vues/VueDemanderMdp.php');
        }
        else {
            // connexion du serveur web à la base MySQL
            include_once ('modele/DAO.class.php');
            $dao = new DAO();
            global $ADR_MAIL_EMETTEUR;
            
            if ( ! $dao->existeUtilisateur($name) ) {
                // si le nom existe déjà, réaffichage de la vue
                $message = "Nom d'utilisateur inexistant !";
                $typeMessage = 'avertissement';
                $themeFooter = $themeProbleme;
                include_once ('vues/VueDemanderMdp.php');
            }
                  
           else {
               $nouveauMdp = Outils::creerMdp();
               $nouveauMdp2 = $dao->modifierMdpUser($nom, $nouveauMdp);
               // envoi d'un mail de confirmation de l'enregistrement
               $adresseDestinataire = $dao->getUtilisateur($name)->getEmail();
               
                $sujet = "Envoi nouveau mot de passe";
                $contenuMail = $dao->envoyerMdp($nom, $nouveauMdp);
                $contenuMail = "L'administrateur du système de réservations de la M2L vous a créé un nouveau mot de passe.\n\n".$nouveauMdp;
                $adresseEmetteur = $ADR_MAIL_EMETTEUR;
                
                $ok = Outils::envoyerMail($adresseDestinataire, $sujet, $contenuMail, $adresseEmetteur);
                if ( ! $ok ) {
                    // si l'envoi de mail a échoué, réaffichage de la vue avec un message explicatif
                    $message = "L'envoi du mail a rencontré un problème !";
                    $typeMessage = 'avertissement';
                    $themeFooter = $themeProbleme;
                    include_once ('vues/VueDemanderMdp.php');
                }
                else {
                    // tout a fonctionné
                    $message = "Nouveau mot de passe créé :  <br>Un mail va vous être envoyé !";
                    $typeMessage = 'information';
                    $themeFooter = $themeNormal;
                    include_once ('vues/VueDemanderMdp.php');
                }
            }
        }
        unset($dao);		// fermeture de la connexion à MySQL
    }