<?php
		//fonction qui récupère la BDD
	function getBdd(){
		$bdd = new PDO('mysql:host=localhost;dbname=gsbV2;charset=utf8',
  'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
		return $bdd;
	}
	
	//fonction qui récupère une liste de login et mdp des Visiteurs
	function recupIDVisiteur () {
		//appel de la fonction getBdd
		getBdd();
		//instanciation d'une requête dans une variable
		$requete = "SELECT * FROM `Visiteur` WHERE login = :login AND mdp = :mdp";
		$query = $bdd->prepare($requete);
		//récupération de la liste des IDs dans une variable;
		$query->execute(array(':login' => $login, ':mdp' => $mdp));
		return $query;	
	}
	
	//fonction qui vérifie l'existance des IDs
	function verifID (){
		 if (!empty($login) && !empty($mdp)) {
			recupIDVisiteur();
			$donnees = $query->fetch();}//on vérifie chaque ligne et on regarde si un visiteur correspond
		else {
			echo "Veuillez remplir tous les champs !";
		}
		return $donnees;
	}
	
	function insertFraisForfait(){
		if (isset($_POST['libelleFraisForfait']) && isset($_POST['quantite'])) {
			$quantite = htmlspecialchars($_POST['quantite']);
			$libelleFraisForfait = htmlspecialchars($_POST['libelleFraisForfait']);
			if(!empty($quantite) && !empty($libelleFraisForfait)) {
				getBdd();
				$mois = date('F'); //On récupère le mois en cours
				//Insert des frais hors forfait dans la base
				$requete = "INSERT INTO `LigneFraisForfait`(idVisiteur, mois, idFraisForfait, quantite) VALUES (:idVisiteur, :mois, :idFraisForfait, :quantite) ON DUPLICATE KEY UPDATE quantite = quantite + :quantite";
				$query = $bdd -> prepare($requete);
				$query -> execute(array(
					':idVisiteur' => $id,
					':mois' => $mois,
					':idFraisForfait' => $libelleFraisForfait,
					':quantite' => $quantite
				));

				$fraisForfait = 'Vos frais forfaitaires ont bien été pris en compte';
			}
			else {
				echo "Veuillez remplir tous les champs !";
			}
		}
	}
	
	function insertFraisHorsForfait(){
		if (isset($_POST['date']) && isset($_POST['libelle']) && isset($_POST['prix'])) {
			$date = htmlspecialchars($_POST['date']);
			$libelle = htmlspecialchars($_POST['libelle']);
			$prix = htmlspecialchars($_POST['prix']);
			if(!empty($date) && !empty($libelle) && !empty($prix)) {
				getBdd();
				$mois = date('F'); //On récupère le mois en cours
				//Insert des frais hors forfait dans la base
				$requete = "INSERT INTO `LigneFraisHorsForfait`(id, idVisiteur, mois, libelle, dateHF, montant) VALUES (NULL, :idVisiteur, :mois, :libelle, :dateHF, :montant)";
				$query = $bdd -> prepare($requete);
				$query -> execute(array(
					':idVisiteur' => $id,
					':mois' => $mois,
					':libelle' => $libelle,
					':dateHF' => $date,
					':montant' => $prix
				));
				$fraisHorsForfait = 'Vos frais Hors Forfaits ont bien été pris en compte';
			}
			else {
				echo "Veuillez remplir tous les champs !";
			}
		}
	}
	
	//Mofification de la table LigneFraisForfait
	function modifTableLFraisForfait(){
		
		if (isset($_POST['ModifQuantite']) && isset($_POST['ModifIdFraisForfait'])) {

			$ModifQuantitéFraisForfait = $_POST['ModifQuantite'];
			$ModifIdFraisForfait = $_POST['ModifIdFraisForfait'];
			$mois = date('F');
			getBdd();
			$ModifQuantité = $bdd -> prepare('UPDATE LigneFraisForfait SET quantite = :quantite WHERE idVisiteur = :id AND idFraisForfait= :idFraisForfait AND mois = :mois');
			$ModifQuantité -> execute(array(':quantite' => $ModifQuantitéFraisForfait, ':id' => $id, ':idFraisForfait' => $ModifIdFraisForfait, ':mois' => $mois));
			if ($ModifQuantité == true) {
				$ModifQuantitéOK = "Les modifications ont bien été prises en compte";
			}
			else {
				echo "Erreur";
			}
		}
	}
	
	 //Supression d'une ligne de la table LigneFraisHorsForfait par méthode GET
	 function suprTableLFraisHorsForfait(){
		if (isset($_GET['supp'])){
			if($_GET['supp'] == 'ok'){
				getBdd();
				$id = $_GET['id']; //Récupération de l'id de la ligne du tableau
				$supprimer = $bdd -> prepare("DELETE FROM LigneFraisHorsForfait WHERE id = :id AND idVisiteur = :idVisiteur");
				$supprimer -> execute(array(':id' => $id, ':idVisiteur' => $_SESSION['id']));
			}
		}
	}
	
	//Mofification de la table LigneFraisHorsForfait
	function modifTableLFraisHorsForfait(){
		if (isset($_POST['ModifDate']) && isset($_POST['ModifDescription']) && isset($_POST['ModifMontant'])) {
			$ModifDate = $_POST['ModifDate'];
			$ModifDescription = $_POST['ModifDescription'];
			$ModifMontant = $_POST['ModifMontant'];
			$ModifIdFraisHorsForfait = $_POST['ModifIdFraisHorsForfait'];
			$mois = date('F');
			getBdd();
			$ModifQuantitéFraisHorsForfait = $bdd -> prepare('UPDATE LigneFraisHorsForfait SET libelle = :libelle, dateHF = :dateHF, montant = :montant WHERE idVisiteur = :id AND id= :idFraisHorsForfait AND mois = :mois');
			$ModifQuantitéFraisHorsForfait -> execute(array(':libelle' => $ModifDescription, ':dateHF' => $ModifDate, ':montant' => $ModifMontant, ':id' => $id, ':idFraisHorsForfait' => $ModifIdFraisHorsForfait, ':mois' => $mois));
			if ($ModifQuantitéFraisHorsForfait == true) {
				$ModifQuantitéFraisHorsForfaitOK = "Les modifications ont bien été prises en compte";
			}
			else {
				echo "Erreur";
			}
		}
	}
	
	function connexion(){
		session_start();
		if (isset($_POST['login']) && isset($_POST['mdp'])){
			verifID();
			if ($donnees == true) { // Si un visiteur correspond{
				//Création des variables de session
				$_SESSION['login'] = $donnees['login'];
				$_SESSION['mdp'] = $donnees['mdp'];
				$_SESSION['id'] = $donnees['id'];
				$_SESSION['nom'] = $donnees['nom'];
				$_SESSION['prenom'] = $donnees['prenom'];
				header ('location: accueil.php'); //Redirection vers la page d'accueil
			}
			else {
			$erreur = "Identifiant ou mot de passe incorrect";
			}
		}
		 else {
			echo "Veuillez remplir tous les champs !";
		}
    }
	
	function verifExistUtilisateur(){
		session_start();
		// on vérifie que les variables de session identifiant l'utilisateur existent
		if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
			$login_sesion = $_SESSION['login'];
			$mdp_session = $_SESSION['mdp'];
			$id = $_SESSION['id'];
			$nom = $_SESSION['nom'];
			$prenom = $_SESSION['prenom'];
		}
	}

	function deconnexion(){
		// On démarre la session
		session_start ();
		// On détruit les variables de notre session
		session_unset ();
		// On détruit notre session
		session_destroy ();
		// On redirige le visiteur vers la page d'accueil
		header ('location: connexion.php');
	}
?>