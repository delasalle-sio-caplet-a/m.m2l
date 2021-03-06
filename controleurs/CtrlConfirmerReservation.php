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
    $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
    $themeFooter = $themeNormal;
    include_once ('vues/VueConfirmerReservation.php');
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
        include_once ('vues/VueConfirmerReservation.php');
    }
    else
    {
        // connexion du serveur web à la base MySQL
        include_once ('modele/DAO.class.php');
        $dao = new DAO();
        
        if ( ! $dao->existeReservation($idRes) ) { // 3
            // si le numéro de réservation est inexistant, réaffichage de la vue de modification avec un message explicatif
            $message = 'Numéro de réservation inexistant !';
            $typeMessage = 'avertissement';
            $themeFooter = $themeProbleme;
            include_once ('vues/VueConfirmerReservation.php');
        }
        else
        {
            if ($dao->estLeCreateur($_SESSION['nom'], $idRes) == false) { // 4
                // si vous etes pas l'auteur de la réservation, réaffichage de la vue de modification avec un message explicatif
                $message = "Vous n'êtes pas le créateur de la réservation !";
                $typeMessage = 'avertissement';
                $themeFooter = $themeProbleme;
                include_once ('vues/VueConfirmerReservation.php');
            }
            else
            {   
                $laReservation = $dao->getReservation($idRes);
                
                if ($laReservation->getStatus() == 0) { // 5
                    // si le numéro de réservation est deja confirmer, réaffichage de la vue de modification avec un message explicatif
                    $message = 'Réservation déjà confirmée !';
                    $typeMessage = 'avertissement';
                    $themeFooter = $themeProbleme;
                    include_once ('vues/VueConfirmerReservation.php');
                }
                else 
                    {
                        $laReservation = $dao->getReservation($idRes);
                {       $laReservation = $dao->getReservation($idRes);
                
                        if ($laReservation->getEnd_time() < time()){ // 6
                        // si la réservation est deja passé, réaffichage de la vue de modification avec un message explicatif
                        $message = 'Réservation déjà passée !';
                        $typeMessage = 'avertissement';
                        $themeFooter = $themeProbleme;
                        include_once ('vues/VueConfirmerReservation.php'); 
                        }
                  else 
                     {
                        $ok = $dao->confirmerReservation($idRes);
                        if ( ! $ok ) { // 7
                            // si l'enregistrement a échoué, réaffichage de la vue avec un message explicatif
                            $message = "Problème lors de l'enregistrement !";
                            $typeMessage = 'avertissement';
                            $themeFooter = $themeProbleme;
                            include_once ('vues/VueConfirmerReservation.php');
                        }
                        else 
                        {
                            // envoi d'un mail de confirmation de l'enregistrement
                            $sujet = "confirmation de votre reservation";
                            $contenuMail = "Vous venez de confirmer votre réservation sur le site M2L\n\n";
                            $contenuMail .= "Votre id de reservation est : " . $idRes . "\n";
                            
                            $adrMail = $dao->getUtilisateur($nom)->getEmail();
                        
                            $ok = Outils::envoyerMail($adrMail, $sujet, $contenuMail, $ADR_MAIL_EMETTEUR);
                            if ( ! $ok ) { // 8
                                // si l'envoi de mail a échoué, réaffichage de la vue avec un message explicatif
                                $message = "Enregistrement effectué.<br>L'envoi du mail à l'utilisateur a rencontré un problème !";
                                $typeMessage = 'avertissement';
                                $themeFooter = $themeProbleme;
                                include_once ('vues/VueConfirmerReservation.php');
                            }
                            else 
                            {
                                // tout a fonctionné
                                $message = "Enregistrement effectué.<br>Un mail va être envoyé à l'utilisateur !";
                                $typeMessage = 'information';
                                $themeFooter = $themeNormal;
                                include_once ('vues/VueConfirmerReservation.php');
                            }  // 8
                      } // 7
                   } // 6
                } // 5
            } // 4
       } // 3
            unset($dao);		// fermeture de la connexion à MySQL    
    } // 2
} // 1
        }