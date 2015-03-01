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
 
    <title>205-PI Carburant</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/starter-template.css" rel="stylesheet">

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


  </head>

  <body>
    <?php
	 if(isset($_GET['date'])&&($_GET['litre'])&&($_GET['prixlitre'])){
		$fix=shell_exec("/home/pi/get_fix");
		if($fix)
		{
			try
			{
				$bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
			}
			catch(Exception $e)
			{
					die('Erreur : '.$e->getMessage());
			}
			
			// les variable
			$date = $_GET['date'];
			list($jour,$mois,$annee) = explode('/',$date);
			$date = $annee.'-'.$mois.'-'.$jour;
			$litre = $_GET['litre'];
			$prixlitre = $_GET['prixlitre'];
			
			// Réccupération de la latitude et longitude
			$latitude=shell_exec("/home/pi/get_lat");
			$longitude=shell_exec("/home/pi/get_lon");
			
			// On insert une entrée
			$sql = "INSERT INTO kilometre (Date,latitude,longitude,litre,prixlitre,essence,kilometre_cumule_essence) VALUES('$date','$latitude','$longitude','$litre','$prixlitre','1','0')";
			// On insert une entrée
			$bdd->exec($sql);

			echo '<div class="alert alert-info">
				<button class="close" data-dismiss="alert" type="button">x</button>
				Ajouté avec succès !
				</div>';
		}
		else{
		echo '<div class="alert alert-warning">
				<button class="close" data-dismiss="alert" type="button">x</button>
				Le GPS n\'est pas synchronisé. Impossible d\'ajouter le plein, merci de recommencer ultérieurement.
				</div>';
		}
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
            <li><a href="entretien.php">Entretien</a></li>
            <li><a href="carnet.php">Carnet de bord</a></li>
            <li class="active"><a href="consommation.php">Consommation</a></li>
            <li><a href="map.php">Carte</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
		<div class="row-fluid">
			<div class="span3">
				<h1>Statistques</h1>
				<button type="button" class="pull-right glyphicon glyphicon-plus btn btn-success" data-toggle="modal" data-target="#myModal" >Ajouter un plein</button>
				<h4>Kil. restant :</h4>
				<h4>Conso. Moyenne :</h4>
				<h4>Conso. Totale :</h4>
				<h4>Prix. Total :</h4>
			</div>
			<div class="span6">
				<h1>Derniers pleins</h1>
				<table class="table table-striped">
				<thead>
					<tr><th>Date</th><th>Litres</th><th>Prix/L</th><th>Kilomètres réalisés</th></tr>
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

					$reponse = $bdd->query('SELECT  Date, litre, prixlitre, kilometre_cumule_essence FROM kilometre WHERE essence=1 ORDER BY Date DESC LIMIT 3');

					while ($donnees = $reponse->fetch())
					{		
						echo '<tr>';
						echo '<td>'.date("d/m/Y", strtotime($donnees['Date'])).'</td>';
						echo '<td>'.$donnees['litre'].'</td>';
						echo '<td>'.$donnees['prixlitre'].'</td>';
						echo '<td>'.$donnees['kilometre_cumule_essence'].'</td>';
						echo '</tr>';
					}

					$reponse->closeCursor();

					?>
				</tbody>
				</table>
			</div>
		</div>
    </div><!-- /.container -->
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
			<h4 class="modal-title" id="myModalLabel">Nouveau plein</h4>
		  </div>
		  <div class="modal-body">
			    <form action="">
					<fieldset>
						<Label>Date</Label>
						<input id="datepicker" type="text" size="28" placeholder="Date du message" name="date" />
					</fieldset><br/>
					<fieldset>
						<label>Litre</label>
						<input type="text"  maxlength="20" placeholder="Nombre de litres..." name="litre">
					</fieldset><br/>
					<fieldset>
						<label>Prix/L</label>
						<input type="number" step="any" max="2" min="0.5" placeholder="1,129" name="prixlitre">
					</fieldset><br/>
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
    
  </body>
</html>
