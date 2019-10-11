<?php

require_once ('modele/fonctions.php');
require_once ('controlleur/fonctions.php');
session_start();  // démarrage d'une session

if(isset($_GET["click"])){
	if ($_GET["click"]==1) {
	$click=0;
    deco();
	}
}



if (!isset($_GET["aller"])=='Accueil'){
	authentification();
}
else{



// on vérifie que les variables de session identifiant l'utilisateur existent
/*if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
    $login = $_SESSION['login'];
    $mdp = $_SESSION['mdp'];*/


		switch(isset($_GET["aller"])){
			case $_GET["aller"]=="Accueil";
				accueil();
				break;

			case $_GET["aller"]=='Consultation';
				consultation();
				break;

			case $_GET["aller"]=='FraisForfait';
				require ("vue/fraisForfait.php");
				break;

			case $_GET["aller"]=='HorsForfait';
				horsForfait();



				break;
		}




}
//}

?>
