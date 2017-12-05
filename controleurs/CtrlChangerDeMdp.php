<?php
// Projet Réservations M2L - version web mobile
// fichier : controleurs/CtrlChangerDeMdp.php
// Rôle : traiter le changement de mot de passe d'un utilisateur
// Création : 07/11/2017 par Lucas Blandin
// Mise à jour : 07/11/2017 par Lucas Blandin

if ( ! isset ($_POST ["txtMdp"]) && ! isset ($_POST ["txtConfirmation"]) ) { // 1
    // si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
    $mdp = '';
    $confirmation = '';
    $message = '';
    $typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
    $themeFooter = $themeNormal;
    include_once ('vues/VueChangerDeMdp.php');
}
else 
{
    // récupération des données postées
    if ( empty ($_POST ["txtMdp"]) == true)  $mdp = "";  else   $mdp = $_POST ["txtMdp"];
    if ( empty ($_POST ["txtConfirmation"]) == true)  $confirmation = "";  else   $confirmation = $_POST ["txtConfirmation"];

    if ($mdp == '' || $confirmation == '') { // 2
        // si les données sont incomplètes, réaffichage de la vue de modification avec un message explicatif
        $message = 'Données incomplètes !';
        $typeMessage = 'avertissement';
        $themeFooter = $themeProbleme;
        include_once ('vues/VueChangerDeMdp.php');
    }
    else 
    {
        if ($mdp != $confirmation) { // 3
            // si les données sont incomplètes, réaffichage de la vue de modification avec un message explicatif
            $message = 'Le nouveau mot de passe et sa confirmation sont différents !';
            $typeMessage = 'avertissement';
            $themeFooter = $themeProbleme;
            include_once ('vues/VueChangerDeMdp.php');
        }
        else 
        {
            // connexion du serveur web à la base MySQL
            include_once ('modele/DAO.class.php');
            $dao = new DAO();
            $nom = $_SESSION['nom'];
            $ok1 = $dao->modifierMdpUser($nom, $mdp);
            if ( ! $ok1 ) { // 4
                // si l'enregistrement a échoué, réaffichage de la vue avec un message explicatif
                $message = "Problème lors de l'enregistrement !";
                $typeMessage = 'avertissement';
                $themeFooter = $themeProbleme;
                include_once ('vues/VueChangerDeMdp.php');
            }
            else 
            {
                // envoi d'un mail de confirmation de l'enregistrement
                $sujet = "Modification de votre mot de passe";
                $contenuMail = "Vous venez de modifier le mot de passe de votre compte M2L\n\n";
                $contenuMail .= "Votre nouveau mot de passe est : " . $mdp . "\n";
                
                $adrMail = $dao->getUtilisateur($nom)->getEmail();
                
                $ok2 = Outils::envoyerMail($adrMail, $sujet, $contenuMail, $ADR_MAIL_EMETTEUR);
                if ( ! $ok2 ) { // 5
                    // si l'envoi de mail a échoué, réaffichage de la vue avec un message explicatif
                    $message = "Enregistrement effectué.<br>L'envoi du mail à l'utilisateur a rencontré un problème !";
                    $typeMessage = 'avertissement';
                    $themeFooter = $themeProbleme;
                    include_once ('vues/VueChangerDeMdp.php');
                }
                else 
                {
                    // tout a fonctionné
                    $message = "Enregistrement effectué.<br>Un mail va être envoyé à l'utilisateur !";
                    $typeMessage = 'information';
                    $themeFooter = $themeNormal;
                    include_once ('vues/VueChangerDeMdp.php');
                } // 5
            } // 4
            unset($dao);		// fermeture de la connexion à MySQL           
        } // 3
    } // 2  
} // 1