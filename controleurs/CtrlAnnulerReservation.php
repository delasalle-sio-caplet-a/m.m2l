<?php
// Projet Réservations M2L - version web mobile
// fichier : controleurs/CtrlConfirmerReservation
// Rôle : traiter la confimrmation d'une réservtion
// Création : 28/11/2017 par Lucas Blandin
// Mise à jour : 28/11/2017 par Lucas Blandin

if ( ! isset ($_POST ["txtIdReservation"]) ) { // 1
    // si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
    $idRes = '';
    $message = '';
    $typeMessage = '';                        // 2 valeurs possibles : 'information' ou 'avertissement'
    $themeFooter = $themeNormal;
    include_once ('vues/VueAnnulerReservation.php');
}
else
{
    // récupération des données postées
    if ( empty ($_POST ["txtIdReservation"]) == true)  $idRes = "";  else   $idRes = $_POST ["txtIdReservation"];
    
    if ($idRes == '') { // 2
        // si les données sont incomplètes ou incorrect, réaffichage de la vue de modification avec un message explicatif
        $message = 'Données incomplètes !';
        $typeMessage = 'avertissement';
        $themeFooter = $themeProbleme;
        include_once ('vues/VueAnnulerReservation.php');
    }
    else
    {
        // connexion du serveur web à la base MySQL
        include_once ('modele/DAO.class.php');
        $dao = new DAO();
        
        if ( ! $dao->existeReservation($idRes) ) { // 3
            // si le numéro de réservtion est inexistant, réaffichage de la vue de modification avec un message explicatif
            $message = 'Numéro de réservation inexistant !';
            $typeMessage = 'avertissement';
            $themeFooter = $themeProbleme;
            include_once ('vues/VueAnnulerReservation.php');
        }
        else
        {
            if ( ! $dao->estLeCreateur($nom, $idRes) ){ // 4
                // si vous etes pas l'auteur de la réservation, réaffichage de la vue de modification avec un message explicatif
                $message = 'Vous n\'êtes pas le créateur de la réservation !';
                $typeMessage = 'avertissement';
                $themeFooter = $themeProbleme;
                include_once ('vues/VueAnnulerReservation.php');
            }
            else {
                $laReservation = $dao->getReservation($idRes);
                if ($laReservation->getEnd_time()< time()){
                    $message = "Cette réservation est déjà passée !";
                    $typeMessage = 'avertissement';
                    $themeFooter = $themeProbleme;
                    include_once ('vues/VueAnnulerReservation.php');
            }
            else
            {
                if ($idRes == 0) { // 5
                    // si le numéro de réservation est deja confirmer, réaffichage de la vue de modification avec un message explicatif
                    $message = 'Reservation deja confirmé !';
                    $typeMessage = 'avertissement';
                    $themeFooter = $themeProbleme;
                    include_once ('vues/VueAnnulerReservation.php');
                }
                else
                {
                    if ( ! $ok1 ) { // 6
                        // si l'enregistrement a échoué, réaffichage de la vue avec un message explicatif
                        $message = "Problème lors de l'enregistrement !";
                        $typeMessage = 'avertissement';
                        $themeFooter = $themeProbleme;
                        include_once ('vues/VueAnnulerReservation.php');
                    }
                    else
                    {
                        // envoi d'un mail de confirmation de l'enregistrement
                        $sujet = "Annulation de votre reservation";
                        $contenuMail = "Vous venez d'annuler votre reservation sur le site M2L\n\n";
                        $contenuMail .= "Votre nouveau mot de passe est : " . $mdp . "\n";
                        
                        $adrMail = $dao->getUtilisateur($nom)->getEmail();
                        
                        $ok2 = Outils::envoyerMail($adrMail, $sujet, $contenuMail, $ADR_MAIL_EMETTEUR);
                        if ( ! $ok2 ) { // 7
                            // si l'envoi de mail a échoué, réaffichage de la vue avec un message explicatif
                            $message = "Enregistrement effectué.<br>L'envoi du mail à l'utilisateur a rencontré un problème !";
                            $typeMessage = 'avertissement';
                            $themeFooter = $themeProbleme;
                            include_once ('vues/VueAnnulerReservation.php');
                        }
                        else
                        {
                            // tout a fonctionné
                            $message = "Enregistrement effectué.<br>Un mail va être envoyé à l'utilisateur !";
                            $typeMessage = 'information';
                            $themeFooter = $themeNormal;
                            include_once ('vues/VueAnnulerReservation.php');
                        }  // 7
                    } // 6
                } // 5
            } // 4
        } // 3
        unset($dao);                // fermeture de la connexion à MySQL
    } // 2
    }
}