<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>205-PI Home</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/starter-template.css" rel="stylesheet">
	
	<script type="text/javascript">
		setInterval("my_function();",1000); 
		function my_function(){
			$('#ajax').load("/cgi-bin/lire_vitesse");
		};	
    </script>

  </head>

  <body>
  
  <?php
	if(isset($_GET['nom'])&&($_GET['description'])){
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=Voiture', 'root', 'bananapi');
		}
		catch(Exception $e)
		{
				die('Erreur : '.$e->getMessage());
		}
		
		// les variable
		$nom = $_GET['nom'];
		$description = $_GET['description'];
				
		# Insertion du nouveau trajet
		$sql1 = "INSERT INTO Trajet (Nom,Description) VALUES('$nom','$description')";
		$bdd->exec($sql1);	
	
		# Recherche de l'ancien ID
		$sql0 = $bdd->query('SELECT MAX(id_trajet) FROM Trajet');
		$req = mysql_query($sql0);
		while($data = mysql_fetch_array($req)) 
		{ 
			echo 'data =' . $data['id_trajet'];
		}
		
		// Update du trajet en cours
		$sql2 = "UPDATE record SET id_trajet_en_cours='$id'";
		$bdd->exec($sql2);		
		

		echo '<div class="alert alert-info">
			<button class="close" data-dismiss="alert" type="button">x</button>
			Ajouté avec succès !
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
            <li class="active"><a href="#">Home</a></li>
            <li><a href="entretien.php">Entretien</a></li>
            <li><a href="carnet.php">Carnet de bord</a></li>
            <li><a href="consommation.php">Consommation</a></li>
            <li><a href="map.php">Carte</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

		<div>
			<h1 class="starter-template" id="ajax">Vitesse</h1>
			</br>
			<button type="button" class="pull-right glyphicon glyphicon-plus btn btn-success" data-toggle="modal" data-target="#myModal" >Ajouter un trajet</button>
		</div>
    </div><!-- /.container -->

		<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fermer</span></button>
			<h4 class="modal-title" id="myModalLabel">Nouveau trajet</h4>
		  </div>
		  <div class="modal-body">
			    <form action="">
					<fieldset>
						<Label>Nom</Label>
						<input id="datepicker" type="text" size="28" placeholder="Nom du trajet" name="nom" />
					</fieldset><br/>
					<fieldset>
						<label>Description</label>
						<input type="text"  maxlength="5" placeholder="Description du trajet" name="description">
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
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
