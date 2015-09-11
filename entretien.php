<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Bootstrap Admin Theme</title>

    <!-- Bootstrap Core CSS -->
    <link href="../bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <!-- jQuery -->
    <script src="../bower_components/jquery/dist/jquery.min.js"></script>
    

    <!-- Bootstrap Core JavaScript -->
    <script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

        
	<script type="text/javascript">
		var photo;
		setInterval("conducteur();",10000); 
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
		setInterval("dateHeure();",30000); 
		function dateHeure(){
			$('#dateHeure').load("/cgi-bin/gps/dateHeure-court");
            $('#fixTemp').load("/cgi-bin/gps/get_fix_cgi");
            $('#netTemp').load("/cgi-bin/internet/check_internet");
		};	
    </script>
        
    <script>
        function start(){
            conducteur();
            dateHeure();
        };
    </script>

</head>

<body onload="start();">

  
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

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">205-PI</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li>
                    <div id="dateHeure"></div>
                </li>
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa  fa-signal  fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>Data</strong>
                                    <span class="pull-right text-muted">
                                        <em id="fixTemp"></em>
                                    </span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-data -->
                </li>
                <!-- /.dropdown -->
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa  fa-rss  fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>GPS</strong>
                                    <span class="pull-right text-muted">
                                        <em id="netTemp"></em>
                                    </span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-data -->
                </li>
                <li>
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa  fa-power-off  fa-fw"></i>
                    </a>
                    
                    <!-- /.dropdown-data -->
                </li>
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <!-- Variable -->
                                <p id="fixTemp" style="display:none;"></p>
                                <p id="netTemp" style="display:none;"></p>
                                <p id="PconducteurTemp" style="display:none;"></p>
                                <p id="tempsConduiteTemp" style="display:none;"></p>
                                <ul>
                                    <li style="list-style-type: none;">
                                        <img id="Pconducteur" src="" alt="Conducteur" height="128" width="128">
                                    </li>
                                    <li style="list-style-type: none;">
                                        <em id="Nconducteur"></em>
                                        <a id="Nconducteur" class="fa  fa-gear  fa-fw"></a>
                                        <p><progress id="tempsConduite" value="0" max="100"></progress></p>
                                    </li>
                                </ul>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Home</a>
                        </li>
                        <li>
                            <a href="entretien.php"><i class="fa fa-table fa-fw"></i> Entretien</a>
                        </li>
                        <li>
                            <a href="dashboard.php"><i class="fa fa-bar-chart-o fa-fw"></i> Statistiques</a>
                        </li>
                        
                        <li>
                            <a href="map.php"><i class="fa fa-globe fa-fw"></i> Carte</a>
                        </li>
                        <li>
                            <a href="carnet.php"><i class="fa fa-book fa-fw"></i> Carnet de bord</a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container">
                <div class="row">
                    <h1 class="page-header">Entretien </h1>
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
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
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

