<!DOCTYPE html>

<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	
	<link rel="stylesheet" href="style.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/css/jquery-ui.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/css/ui.theme.css" type="text/css" media="all" />
 
    <title>205-PI Entretien</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/starter-template.css" rel="stylesheet">

  </head>

  <body>
	
    <?php
	 if(isset($_GET['description'])&&($_GET['date'])&&($_GET['kilometre'])&&($_GET['categorie'])){
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
		}
		catch(Exception $e)
		{
				die('Erreur : '.$e->getMessage());
		}
		
		// les variable
		$description = $_GET['description'];
		$date = $_GET['date'];
		list($jour,$mois,$annee) = explode('/',$date);
		$date = $annee.'-'.$mois.'-'.$jour;
		$kilometre = intval($_GET['kilometre']);
		$categorie = $_GET['categorie'];
		
		
		// On insert une entrée
		$sql = "INSERT INTO entretien (description,kilometrage,categorie,date) VALUES('$description','$kilometre','$categorie','$date')";
		// On insert une entrée
		$bdd->exec($sql);

		echo '<div class="alert alert-info">
			<button class="close" data-dismiss="alert" type="button">x</button>
			Ajouté avec succès !
			</div>';
	}
	if(isset($_GET['delete'])){
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
			}
			catch(Exception $e)
			{
					die('Erreur : '.$e->getMessage());
			}
			
			// les variable
			$id = $_GET['delete'];
			
			$sql = "DELETE FROM entretien WHERE Id='$id'";
			// On supprime une entrée
			$bdd->exec($sql);

			echo '<div class="alert alert-info">
			<button class="close" data-dismiss="alert" type="button">x</button>
			Supprimé avec succès !
			</div>';
	}
	?>
	
	<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">205 PI</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="index.php">Home</a></li>
            <li class="active"><a href="entretien.php">Entretien</a></li>
            <li><a href="carnet.php">Carnet de bord</a></li>
            <li><a href="consommation.php">Consommation</a></li>
            <li><a href="map.php">Carte</a></li>
	    <li><a href="index.php">Close</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
		<div class="starter-template">
			<button type="button" class="pull-right glyphicon glyphicon-plus btn btn-success" data-toggle="modal" data-target="#myModal" >Ajouter un entretien</button>
		</div>
		<div class="table">
			<table class="table table-striped">
			<thead>
				<tr><th>Date</th><th>Kilometrage</th><th>Catégorie</th><th>Description</th><th>Supprimer</th></tr>
			</thead>
			<tbody>
			<?php
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
			}
			catch(Exception $e)
			{
					die('Erreur : '.$e->getMessage());
			}

			$reponse = $bdd->query('SELECT * FROM entretien ORDER BY Date DESC');

			while ($donnees = $reponse->fetch())
			{		
				echo '<tr>';
				echo '<td>'.date("d/m/Y", strtotime($donnees['Date'])).'</td>';
				echo '<td>'.$donnees['Kilometrage'].'</td>';
				echo '<td>'.$donnees['Categorie'].'</td>';
				echo '<td>'.$donnees['Description'].'</td>';
				echo '<td><form>
				<input type="hidden" name=delete value='.$donnees['Id'].'>
				<button class="glyphicon glyphicon-remove btn-small btn-danger" type="submit"></button></form></td>';
				echo '</tr>';
			}

			$reponse->closeCursor();

			?>
			</tbody>
			</table>
		</div>
    </div><!-- /.container -->
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
			<h4 class="modal-title" id="myModalLabel">Nouvel entretien</h4>
		  </div>
		  <div class="modal-body">
			    <form action="">
					<fieldset>
						
						<Label>Date: </Label>
						<input id="datepicker" type="text" size="28" placeholder="Date de l'entretien…" name="date" />
					</fieldset><br/>
					<fieldset>
						<label>Kilomètre</label>
						<input type="number" min="0" max="999999" placeholder="Nombre de kilomètre…" name="kilometre">
					</fieldset><br/>
					<fieldset>
						<label>Catégorie</label>
						<select name="categorie">
							<option>Mécanique</option>
							<option>Vidange</option>
							<option>Plaquettes</option>
							<option>Disques</option>
							<option>Carosserie</option>
							<option>Electricité</option>
							<option>Administratif</option>
						</select>
					</fieldset><br/>
					<fieldset>
						<label>Description</label>
						<input type="text" placeholder="Description de l'entretien réalisé…" name="description">			
					</fieldset>
						<input class="btn btn-primary" type="submit">
					</form>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
		  </div>
		</div>
	  </div>
	</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/bootstrap.min.js"></script>
	<script>
		$(function() {
			$( "#datepicker" ).datepicker({
				altField: "#datepicker",
				closeText: 'Fermer',
				prevText: 'Précédent',
				nextText: 'Suivant',
				currentText: 'Aujourd\'hui',
				monthNames: ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'],
				monthNamesShort: ['Janv.', 'Févr.', 'Mars', 'Avril', 'Mai', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
				dayNames: ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'],
				dayNamesShort: ['Dim.', 'Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.'],
				dayNamesMin: ['D', 'L', 'M', 'M', 'J', 'V', 'S'],
				weekHeader: 'Sem.',
				dateFormat: 'dd/mm/yy'
				});
			}
		);
	</script>

  </body>
</html>
