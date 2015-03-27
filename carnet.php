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
 
    <title>205-PI Carnet de bord</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/starter-template.css" rel="stylesheet">
	
	<!-- Timeline CSS -->
    <link href="css/plugins/timeline.css" rel="stylesheet">

	<!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
  </head>

  <body>
	
    <?php
	if(isset($_GET['date'])&&($_GET['auteur'])&&($_GET['lieu'])&&($_GET['jour'])&&($_GET['message'])){
		$fix=shell_exec("/var/www/cgi-bin/gps/get_fix");
		if($fix==1)
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
			$heure = $_GET['heure'];
			$jour = $_GET['jour'];
			$auteur = $_GET['auteur'];
			$lieu = $_GET['lieu'];
			$message = $_GET['message'];
			
			// Réccupération de la latitude et longitude
			$latitude=shell_exec("/var/www/cgi-bin/get_lat");
			$longitude=shell_exec("/var/www/cgi-bin/get_lon");
			$id_trajet=shell_exec("/var/www/cgi-bin/get_id_trajet");
			
			$latitude=round($latitude, 4);
			$longitude=round($longitude, 4);
							
			// On insert une entrée
			$sql = "INSERT INTO carnet (Date,gps,longitude,latitude,Heure,Auteur,Lieu,Message,Jour,id_trajet) VALUES('$date','1','$longitude','$latitude','$heure','$auteur','$lieu','$message','$jour','$id_trajet')";
			
			// On insert une entrée
			$bdd->exec($sql);

			echo '<div class="alert alert-info">
				<button class="close" data-dismiss="alert" type="button">x</button>
				Ajouté avec succès !
				</div>';
		}
		// Si pas de FIX
		else{
		
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
			$heure = $_GET['heure'];
			$jour = $_GET['jour'];
			$auteur = $_GET['auteur'];
			$lieu = $_GET['lieu'];
			$message = $_GET['message'];
			
			// On insert une entrée
			$sql = "INSERT INTO carnet (Date,gps, Heure,Auteur,Lieu,Message,Jour) VALUES('$date','0','$heure','$auteur','$lieu','$message','$jour')";
			$bdd->exec($sql);
			
			echo '
			<div class="alert alert-warning">
			<button class="close" data-dismiss="alert" type="button">x</button>
			Ajouté avec succès sans coordonnés GPS.
			</div>';
		}
	}

	// Suppression d'une entrée
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
			
			$sql = "DELETE FROM carnet WHERE Id='$id'";
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
            <li><a href="entretien.php">Entretien</a></li>
            <li class="active"><a href="carnet.php">Carnet de bord</a></li>
            <li><a href="consommation.php">Consommation</a></li>
            <li><a href="map.php">Carte</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
		<div class="starter-template">
			<button type="button" class="pull-right glyphicon glyphicon-globe btn btn-info" onclick="window.location.href='/map.php'"> Voir carte</button>
			<button type="button" class="pull-right glyphicon glyphicon-plus btn btn-success" data-toggle="modal" data-target="#myModal" >Ajouter un message</button>
		</div>	
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-flag fa-fw"></i> Les messages du raid !
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<ul class="timeline">
				<?php
				try
				{
					$bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
				}
				catch(Exception $e)
				{
						die('Erreur : '.$e->getMessage());
				}

				$reponse = $bdd->query('SELECT * FROM carnet ORDER BY Date DESC');

				while ($donnees = $reponse->fetch())
				{		
					if($donnees['Jour']%2 != 0)
					{
						echo '<li>';
					}
					else
					{
						echo '<li class="timeline-inverted">';
					}
					echo '<div class="timeline-badge">J-'.$donnees['Jour'].'</div>';
					echo '<div class="timeline-panel"><div class="timeline-heading"><h4 class="timeline-title">'.$donnees['Auteur'].'</h4>';
					

					echo '<div class="timeline-body"><p>'.$donnees['Message'].'</p></div>';
					echo '<hr></hr>';
					echo '<form>';
					echo '<small class="text-muted"><i class="fa fa-clock-o"></i> '.date("d/m/Y", strtotime($donnees['Date'])).' - '.$donnees['Heure'].' </small>';
					echo '<small class="text-muted"><i class="fa fa-road"></i> '.$donnees['Lieu'].'</small>';
					echo '<div class="pull-right">';
					if($donnees['gps']==1)
					{
						echo '<a class="glyphicon btn-small btn-success" href="https://maps.google.fr/maps?q='.$latitude.','.$longitude.'">GPS</a>';
					}
					else
					{
						echo '<p class="glyphicon btn-small btn-danger">GPS</p>';
					}
					echo '<input type="hidden" name="delete" value='.$donnees['Id'].'>					
						<button class="glyphicon glyphicon-remove btn-small btn-danger" type="submit"></button>
					</form>';
					echo '</li>';
					}
					echo '</div>';
					echo '</div>';

				$reponse->closeCursor();

				?>
					</ul>
			</div>
			<!-- /.panel-body -->
		</div>
					
    </div><!-- /.container -->
	
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
			<h4 class="modal-title" id="myModalLabel">Nouveau message</h4>
		  </div>
		  <div class="modal-body">
			    <form action="">
					<fieldset>
						<Label>Jour du raid</Label>
						<input type="number" size="2" placeholder="1,2,3..." name="jour" />
					</fieldset><br/>
					<fieldset>
						<Label>Date</Label>
						<input id="datepicker" type="text" size="28" placeholder="Date du message" name="date" />
					</fieldset><br/>
					<fieldset>
						<label>Heure</label>
						<input type="text"  maxlength="5" placeholder="hh:mm..." name="heure">
					</fieldset><br/><fieldset>
						<label>Auteur</label>
						<input type="text"  maxlength="20" placeholder="Nom de l'auteur..." name="auteur">
					</fieldset><br/>
					<fieldset>
						<label>Lieu</label>
						<input type="text"  maxlength="30" placeholder="Nom du lieu..." name="lieu">
					</fieldset><br/>
					<fieldset>
						<label>Message</label>
						<input type="textarea"  maxlength="300" placeholder="Ecrivez votre message" name="message">			
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
