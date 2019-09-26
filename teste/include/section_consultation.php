<section>
  <div class="container" id="section">
    <h2>Consultation des frais</h2>
    <div class="moisEtat">
      <div class="element">
        <form class="form-inline" action="consultation.php" method="post" id="consultationMois">
          <div class="form-group">
            <label for="moisConsult"> Consultez votre fiche de frais au mois de : </label>
            <select class="form-control" id="moisConsult" name="moisConsult">
              <option value="January">Janvier</option>
              <option value="February">Fevrier</option>
              <option value="March">Mars</option>
              <option value="April">Avril</option>
              <option value="May">Mai</option>
              <option value="June">Juin</option>
              <option value="July">Juillet</option>
              <option value="August">Août</option>
              <option value="September">Septembre</option>
              <option value="October">Octobre</option>
              <option value="November">Novembre</option>
              <option value="December">Décembre</option>
            </select>
            <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Valider</button>
          </div>
        </form>
      </div>
      <div class="element"> <p>Etat de la fiche de frais: </p> </div>
    </div>

<?php // Requête pour afficher les frais forfaitaires et les frais hors forfait

  if(isset($_POST['moisConsult'])) {

    $moisConsultation = $_POST['moisConsult'];

    try {
      $bdd= new PDO('mysql:host=localhost;dbname=gsbV2;charset=utf8', 'root', 'password');
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $e){
      die('Erreur : '. $e->getMessage());
    }

    $queryFraisHorsForfait = $bdd -> prepare('SELECT dateHF, libelle, montant, id FROM LigneFraisHorsForfait WHERE mois = :mois AND idVisiteur = :id');
    $queryFraisHorsForfait -> execute(array(':mois' => $moisConsultation, ':id' => $id));

    $queryFraisForfait = $bdd -> prepare('SELECT libelle, quantite, idFraisForfait FROM LigneFraisForfait, FraisForfait WHERE LigneFraisForfait.idFraisForfait = FraisForfait.id AND mois = :mois AND idVisiteur = :id');
    $queryFraisForfait -> execute(array(':mois' => $moisConsultation, ':id' => $id));

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

  </div>
</section>


<?php //Mofification de la table LigneFraisForfait

  if (isset($_POST['ModifQuantite']) && isset($_POST['ModifIdFraisForfait'])) {

    $ModifQuantitéFraisForfait = $_POST['ModifQuantite'];
    $ModifIdFraisForfait = $_POST['ModifIdFraisForfait'];
    $mois = date('F');

    try {
      $bdd= new PDO('mysql:host=localhost;dbname=gsbV2;charset=utf8', 'root', 'password');
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $e){
      die('Erreur : '. $e->getMessage());
    }

    $ModifQuantité = $bdd -> prepare('UPDATE LigneFraisForfait SET quantite = :quantite WHERE idVisiteur = :id AND idFraisForfait= :idFraisForfait AND mois = :mois');
    $ModifQuantité -> execute(array(':quantite' => $ModifQuantitéFraisForfait, ':id' => $id, ':idFraisForfait' => $ModifIdFraisForfait, ':mois' => $mois));

    if ($ModifQuantité == true) {
      $ModifQuantitéOK = "Les modifications ont bien été prises en compte";
    }
    else {
      echo "Erreur";
    }

  }

?>


<?php //Mofification de la table LigneFraisHorsForfait

  if (isset($_POST['ModifDate']) && isset($_POST['ModifDescription']) && isset($_POST['ModifMontant'])) {

    $ModifDate = $_POST['ModifDate'];
    $ModifDescription = $_POST['ModifDescription'];
    $ModifMontant = $_POST['ModifMontant'];
    $ModifIdFraisHorsForfait = $_POST['ModifIdFraisHorsForfait'];
    $mois = date('F');

    try {
      $bdd= new PDO('mysql:host=localhost;dbname=gsbV2;charset=utf8', 'root', 'password');
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $e){
      die('Erreur : '. $e->getMessage());
    }

    $ModifQuantitéFraisHorsForfait = $bdd -> prepare('UPDATE LigneFraisHorsForfait SET libelle = :libelle, dateHF = :dateHF, montant = :montant WHERE idVisiteur = :id AND id= :idFraisHorsForfait AND mois = :mois');
    $ModifQuantitéFraisHorsForfait -> execute(array(':libelle' => $ModifDescription, ':dateHF' => $ModifDate, ':montant' => $ModifMontant, ':id' => $id, ':idFraisHorsForfait' => $ModifIdFraisHorsForfait, ':mois' => $mois));

    if ($ModifQuantitéFraisHorsForfait == true) {
      $$ModifQuantitéFraisHorsForfaitOK = "Les modifications ont bien été prises en compte";
    }
    else {
      echo "Erreur";
    }

  }

?>


<?php //Supression d'une ligne de la table LigneFraisHorsForfait par méthode GET
if (isset($_GET['supp']))
{
	if($_GET['supp'] == 'ok')
	{
    try {
      $bdd= new PDO('mysql:host=localhost;dbname=gsbV2;charset=utf8', 'root', 'password');
      $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(Exception $e){
      die('Erreur : '. $e->getMessage());
    }

  		$id = $_GET['id']; //Récupération de l'id de la ligne du tableau
  		$supprimer = $bdd -> prepare("DELETE FROM LigneFraisHorsForfait WHERE id = :id AND idVisiteur = :idVisiteur");
  		$supprimer -> execute(array(':id' => $id, ':idVisiteur' => $_SESSION['id']));
  	}

	}
?>
