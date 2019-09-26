<?php

require_once ('fonctions.php');
session_start();  // démarrage d'une session

if(isset($_GET["click"])){
	if ($_GET["click"]==1) {
	$click=0;
    deco();
	}
}
if (isset($_GET["aller"])){
	if ($_GET["aller"]=="Accueil"){
		require ("accueil.php");
	}
	if ($_GET["aller"]=='Consultation'){
		require ("Consultation.php");
	}
}
// on vérifie que les variables de session identifiant l'utilisateur existent
if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
    $login = $_SESSION['login'];
    $mdp = $_SESSION['mdp'];
}
if (!(isset($_GET["aller"])=='Accueil')){
	authentification();
}

?>
