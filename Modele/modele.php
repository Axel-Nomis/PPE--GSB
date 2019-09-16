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
		$bdd=getBdd();
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
			$query=recupIDVisiteur();
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
				$bdd=getBdd();
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
				$bdd=getBdd();
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
			$bdd=getBdd();
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
				$bdd=getBdd();
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
			$bdd=getBdd();
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
		verifSession();
		if (isset($_POST['login']) && isset($_POST['mdp'])){
			$donnees=verifID();
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
		verifSession();
		// on vérifie que les variables de session identifiant l'utilisateur existent
		if (isset($_SESSION['login']) && isset($_SESSION['mdp'])) {
			$login_sesion = $_SESSION['login'];
			$mdp_session = $_SESSION['mdp'];
			$id = $_SESSION['id'];
			$nom = $_SESSION['nom'];
			$prenom = $_SESSION['prenom'];
		}
	}

	function

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
	function verifSession(){
		if(!session_id()){
			session_start();
		}
	}
	function recupFraisForfait (){
		$moisConsultation = $_POST['moisConsult'];
		$bdd=getBdd();
		$queryFraisForfait = $bdd -> prepare('SELECT libelle, quantite, idFraisForfait FROM LigneFraisForfait, FraisForfait WHERE LigneFraisForfait.idFraisForfait = FraisForfait.id AND mois = :mois AND idVisiteur = :id');
		$queryFraisForfait -> execute(array(':mois' => $moisConsultation, ':id' => $id));
		return $queryFraisForfait;
	}
	function recupFraisHorsForfait(){
		$moisConsultation = $_POST['moisconsult'];
		$bdd=getBdd();
		$queryFraisHorsForfait = $bdd -> prepare('SELECT dateHF, libelle, montant, id FROM LigneFraisHorsForfait WHERE mois = :mois AND idVisiteur = :id');
		$queryFraisHorsForfait -> execute(array(':mois' => $moisConsultation, ':id' => $id));
		return $queryFraisHorsForfait;
	}
	function affichageFrais(){
		if(isset($_POST['moisConsult'])) {
			//accès BDD et traitement des données
			$moisConsultation = $_POST['moisConsult'];
			$bdd=getBdd();
			$queryFraisForfait=recupFraisForfait();
			$queryFraisHorsForfait=recupFraisHorsForfait();
			$NbDonneesFraisForfait = $queryFraisForfait -> rowcount(); //Vérifie s'il y a des lignes dans la table LigneFraisForfait
			$rowAllFraisForfait = $queryFraisForfait -> fetchall(); //Récupère toutes les données de la table
			$NbDonneesFraisHorsForfait = $queryFraisHorsForfait -> rowcount(); //Vérifie s'il y a des lignes dans la table LigneFraisHorsForfait
			$rowAllFraisHorsForfait = $queryFraisHorsForfait -> fetchall(); //Récupère toutes les données de la table

			// affichage
			if ($NbDonneesFraisForfait != 0) //Affichage de l'entête s'il y a des lignes dans la table LigneFraisForfait
			{
			?>
				<p>Frais forfaitaires du mois de : <?php if (isset($moisConsultation)) { echo $moisConsultation;} ?></p>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th scope="col">Quantité</th>
							<th scope="col">Libellé</th>
							<th scope="col">Opérations</th>
						</tr>
			<?php
					// pour chaque ligne (chaque enregistrement)
					foreach ( $rowAllFraisForfait as $rowFraisForfait )
					{
						// DONNEES de la table LigneFraisForfait
			?>
					<form action="consultation.php" method="post">
						<tr>
							<td> <input type="number" min="0" name="ModifQuantite" value="<?php echo $rowFraisForfait['quantite']; ?>"> </td>
							<td>
								<?php echo $rowFraisForfait['libelle']; ?>
								<input type="hidden" name="ModifIdFraisForfait" value="<?php echo $rowFraisForfait['idFraisForfait']; ?>">
							</td>
							<td>
								<div class="text-center">
								<button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Modifier</button>
								</div>
							</td>
							</tr>
					</form>
			<?php
					} // fin foreach
			?>
					</thead>
				</table>
			<?php
			} else { ?>
				<p>Pas de frais forfaitaires pour le mois en cours !</p>
			<?php
			}

			// affichage
    if ($NbDonneesFraisHorsForfait != 0) //Affichage de l'entête s'il y a des données dans la table LigneFraisHorsForfait
    {
    ?>
      <p>Frais hors forfait du mois de <?php if (isset($moisConsultation)) { echo $moisConsultation;} ?> : </p>
    	<table class="table table-bordered">
      	<thead>
      		<tr>
            <th scope="col">Date</th>
            <th scope="col">Description</th>
            <th scope="col">Prix</th>
            <th scope="col">Opérations</th>
      		</tr>
    <?php
    	// pour chaque ligne (chaque enregistrement)
    	foreach ( $rowAllFraisHorsForfait as $rowFraisHorsForfait )
    	{
        $id = $rowFraisHorsForfait['id'];
    		// DONNEES A AFFICHER de la table LigneFraisHorsForfait
    ?>
      <form action="consultation.php" method="post">
    		<tr>
    			<td> <input type="date" name="ModifDate" value="<?php echo $rowFraisHorsForfait['dateHF']; ?>"> </td>
    			<td> <input type="text" name="ModifDescription" value="<?php echo $rowFraisHorsForfait['libelle']; ?>"> </td>
          <td>
            <input type="number" min="0" name="ModifMontant" value="<?php echo $rowFraisHorsForfait['montant']; ?>">
            <input type="hidden" name="ModifIdFraisHorsForfait" value="<?php echo $rowFraisHorsForfait['id']; ?>">
          </td>
          <td>
            <div class="text-center">
              <button type="submit" class="btn btn-primary"><i class="fas fa-edit"></i> Modifier</button>
              <?php echo '<a href="?id='. $id .'&supp=ok"><button type="button" class="btn btn-primary"><i class="fas fa-trash-alt"></i> Supprimer</button></a>'; ?>
            </div>
          </td>
    		</tr>
      </form>
    <?php
    	} // fin foreach
    ?>
          </thead>
        </table>
    <?php
    }
    else { ?>
    	<p>Pas de frais hors forfait pour le mois en cours !</p>
    <?php
    }
  }
?>