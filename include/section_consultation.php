<section>
  <div class="container" id="section">
    <h2>Consultation des frais</h2>
    <div class="moisEtat">
      <div class="element">
        <form class="form-inline" action="index.php?aller=Consultation" method="post" id="consultationMois">
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



  </div>
</section>


<?php //Mofification de la table LigneFraisForfait

  if (isset($_POST['ModifQuantite']) && isset($_POST['ModifIdFraisForfait'])) {

    $ModifQuantitéFraisForfait = $_POST['ModifQuantite'];
    $ModifIdFraisForfait = $_POST['ModifIdFraisForfait'];
    $mois = date('F');

    $bdd = getBdd();

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

    $bdd = getBdd();

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
    
    $bdd = getBdd();

  		$id = $_GET['id']; //Récupération de l'id de la ligne du tableau
  		$supprimer = $bdd -> prepare("DELETE FROM LigneFraisHorsForfait WHERE id = :id AND idVisiteur = :idVisiteur");
  		$supprimer -> execute(array(':id' => $id, ':idVisiteur' => $_SESSION['id']));
  	}

	}
?>
