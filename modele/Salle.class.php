<?php
// Projet Réservations M2L - version web mobile
// fichier : modele/Salle.class.php
// Rôle : 
// Création : 03/10/2017 par Lucas
// Mise à jour : 

class Salle
{
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------- Membres privés de la classe ---------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    // Rappel : le temps UNIX mesure le nombre de secondes écoulées depuis le 1/1/1970
    // les types des champs timestamp, start_time et end_time découlent des types choisis pour la BDD
    private $id;			
    private $room_name;		
    private $capacity;	
    private $area_name;				
    
    // ------------------------------------------------------------------------------------------------------
    // ----------------------------------------- Constructeur -----------------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    public function Salle($unId, $unRoomName, $unCapacity, $unAreaName) {
        $this->id = $unId;
        $this->room_name = $unRoomName;
        $this->capacity = $unCapacity;
        $this->area_name = $unAreaName;
    }
    
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------------- Getters et Setters ------------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    public function getId()	{return $this->id;}
    public function setId($unId) {$this->id = $unId;}
    
    public function getRoom_name()	{return $this->room_name;}
    public function setRoom_name($unRoom_name) {$this->room_name = $unRoom_name;}
    
    public function getCapacity()	{return $this->capacity;}
    public function setCapacity($unCapacity) {$this->capacity = $unCapacity;}
    
    public function getArea_name()	{return $this->area_name;}
    public function setArea_name($unArea_name) {$this->area_name = $unArea_name;}
    
    // ------------------------------------------------------------------------------------------------------
    // ---------------------------------------- Méthodes d'instances ----------------------------------------
    // ------------------------------------------------------------------------------------------------------
    
    public function toString() {
        $msg = "Salle : <br>";
        $msg .= "id : " . $this->id . "<br>";
        $msg .= "room_name : " . $this->room_name . "<br>";
        $msg .= "capacity : " . $this->capacity . "<br>";
        $msg .= "area_name : " . $this->area_name . "<br>";
        return $msg;
    }
    
} // fin de la classe Salle
>>>>>>> branch 'master' of https://github.com/delasalle-sio-caplet-a/m.m2l.git


// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces après la balise de fin de script !!!!!!!!!!!!