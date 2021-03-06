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
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/starter-template.css" rel="stylesheet">
	
	<script type="text/javascript">
		setInterval("lire_vitesse();",1000); 
		function lire_vitesse(){
			$('#ajax').load("/cgi-bin/gps/lire_vitesse");
		};	
    </script>
	
	<script type="text/javascript">
		var photo;
		setInterval("conducteur();",5000); 
		function conducteur(){
			$('#Nconducteur').load("/cgi-bin/conducteur/conducteur_nom");
			$('#PconducteurTemp').load("/cgi-bin/conducteur/conducteur_photo");
			photo = $('#PconducteurTemp').html();
			$('#Pconducteur').attr('src', photo);
			$('#tempsConduiteTemp').load("/cgi-bin/conducteur/tempsConduite");
			tempsConduite = $('#tempsConduiteTemp').html();
			$('#tempsConduite').attr('value',tempsConduite.trim());
		};	
    </script>
	
	<script type="text/javascript">
		setInterval("dateHeure();",5000); 
		function dateHeure(){
			$('#dateHeure').load("/cgi-bin/gps/dateHeure-court");
			$('#tempInt').load("/cgi-bin/temperature/tempInt");
            $('#fixTemp').load("/cgi-bin/gps/get_fix_cgi");
            $('#netTemp').load("/cgi-bin/internet/check_internet");
			photoFix = $('#fixTemp').html();
			$('#Pfix').attr('src', photoFix);
            photoNet = $('#netTemp').html();
			$('#Pnet').attr('src', photoNet);
		};	
    </script>
    
	

  </head>

  <body>
  
  <?php
  
     FUNCTION updateTrajetPHP(){
     #update pour termin� le trajet
             try
            {
                $bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
            }
            catch(Exception $e)
            {
                    die('Erreur : '.$e->getMessage());
            }
            $sql = "UPDATE Trajet SET encours=0 order by id_trajet desc limit 1";
            $bdd->exec($sql);
            echo 'Trajet termin�!';
     }
 
  
    # V�rifie si le dernier trajet est termin� � l'allumage
    try
    {
        $bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
    }
    catch(Exception $e)
    {
            die('Erreur : '.$e->getMessage());
    }
        
    $sql0 = "SELECT connexion as connexion FROM Instantane order by Id desc limit 1"; 
    foreach  ($bdd->query($sql0) as $row) {
        $connexion = $row['connexion'];
    } 

     if($connexion=='1'){
        $sql1 = "SELECT encours AS encours FROM Trajet order by id_trajet desc limit 1"; 		
        foreach  ($bdd->query($sql1) as $row) {
            $encours = $row['encours'];
        } 
        
        
         if($encours==1){
           # Le trajet en cours n'est pas termin�
           echo '<div class="alert alert-warning">
			<button class="close" data-dismiss="alert" type="button">x</button>
			Dernier trajet non termine. 
			<input id="clickMe" type="button" value="Terminer le trajet" onclick="updateTrajetJS();" />
			</div>';
        }

        #update pour ne plus afficher le message
        $sql2 = "UPDATE Instantane SET connexion=0";
        $bdd->exec($sql2);        
    }
    
    
	# Ajout d'un nouveau trajet
	if(isset($_GET['nom']) || ($_GET['nom']) && ($_GET['description'])){
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
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
	
		# Recherche de l'id du trajet en cours
		$sql = "SELECT MAX(id_trajet) AS id_trajet FROM Trajet"; 		
		foreach  ($bdd->query($sql) as $row) {
			$id = $row['id_trajet'];
		}
		
		// Update du trajet en cours
		$sql2 = "UPDATE Instantane SET Trajet_en_cours=".$id."";
		$bdd->exec($sql2);

		// Mise � 0 des kil partiel
		$sql3 = "UPDATE kilometre SET kilometre_cumule_partiel=0 order by Id desc limit 1";
		$bdd->exec($sql3);
		
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
			<li><a id="dateHeure">Heure</a></li>
			<li><a id="tempInt">Temp</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

		<div>
			<h1 class="starter-template" id="ajax">Vitesse</h1>
			</br>
			<p id="fixTemp" style="display:none;"></p>
			<p id="netTemp" style="display:none;"></p>
			<p id="Nconducteur"></p>
			<p id="PconducteurTemp" style="display:none;"></p>
			<p id="tempsConduiteTemp" style="display:none;"></p>
			<p><progress id="tempsConduite" value="0" max="100"></progress></p>
			<img id="Pconducteur" src="" alt="Conducteur" height="64" width="64">
			<img id="Pfix" src="" alt="fix" height="64" width="64">
			<img id="Pnet" src="" alt="data net" height="64" width="64">
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
    
    <script>
    function updateTrajetJS(){
     alert("<?PHP updateTrajetPHP(); ?>");
     document.getElementById(clickMe).style.visibility="hidden";
     }
    </script>
  </body>
</html>
