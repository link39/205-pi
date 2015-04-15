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
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

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
    
    
    <link rel="stylesheet" href="js/jqwidgets/styles/jqx.base.css" type="text/css" />
    <script type="text/javascript" src="js/jqwidgets/jqxcore.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxdraw.js"></script>
    <script type="text/javascript" src="js/jqwidgets/jqxgauge.js"></script>
        
    <script type="text/javascript">
        $(document).ready(function () {         
            $('#Int').jqxGauge({
                ranges: [{ startValue: -15, endValue: 10, style: { fill: '#87CEFA', stroke: '#87CEFA' }, startDistance: 0, endDistance: 0 },
                         { startValue: 10, endValue: 20, style: { fill: '#4cb848', stroke: '#4cb848' }, startDistance: 0, endDistance: 0 },
                         { startValue: 20, endValue: 30, style: { fill: '#fad00b', stroke: '#fad00b' }, startDistance: 0, endDistance: 0},
                         { startValue: 30, endValue: 50, style: { fill: '#e53d37', stroke: '#e53d37' }, startDistance: 0, endDistance: 0}],     
                labels: { position: 'outside', interval: 10 },
                border:{visible: false},
                caption: { offset: [0, -25], value: 'Int', position: 'bottom' },
                min:-15,
                max:50,
                animationDuration: 1500,
                width: 150,
                height:150
            });
            $('#Int').jqxGauge('value', 30);
        });
        $(document).ready(function () {         
            $('#Ext').jqxGauge({
                ranges: [{ startValue: -15, endValue: 10, style: { fill: '#87CEFA', stroke: '#87CEFA' }, startDistance: 0, endDistance: 0 },
                         { startValue: 10, endValue: 20, style: { fill: '#4cb848', stroke: '#4cb848' }, startDistance: 0, endDistance: 0 },
                         { startValue: 20, endValue: 30, style: { fill: '#fad00b', stroke: '#fad00b' }, startDistance: 0, endDistance: 0},
                         { startValue: 30, endValue: 50, style: { fill: '#e53d37', stroke: '#e53d37' }, startDistance: 0, endDistance: 0}],     
                labels: { position: 'outside', interval: 10 },
                border:{visible: false},
                caption: { offset: [0, -25], value: 'Ext', position: 'bottom' },
                min:-15,
                max:50,
                animationDuration: 1500,
                width: 150,
                height:150
            });
            $('#Ext').jqxGauge('value', 20);
        });
        $(document).ready(function () {         
            $('#Mot').jqxGauge({
                ranges: [{ startValue: 70, endValue: 85, style: { fill: '#87CEFA', stroke: '#87CEFA' }, startDistance: 0, endDistance: 0 },
                         { startValue: 85, endValue: 90, style: { fill: '#4cb848', stroke: '#4cb848' }, startDistance: 0, endDistance: 0 },
                         { startValue: 90, endValue: 95, style: { fill: '#fad00b', stroke: '#fad00b' }, startDistance: 0, endDistance: 0},
                         { startValue: 95, endValue: 110, style: { fill: '#e53d37', stroke: '#e53d37' }, startDistance: 0, endDistance: 0}],     
                labels: { position: 'outside', interval: 5 },
                border:{visible: false},
                caption: { offset: [0, -25], value: 'Moteur', position: 'bottom' },
                min:70,
                max:110,
                animationDuration: 1500,
                width: 200,
                height:200
            });
            $('#Mot').jqxGauge('value', 90);
        });
    </script>
    
    <!-- Script pour la PI  -->
   <script type="text/javascript">
		setInterval("lire_vitesse();",1000); 
		function lire_vitesse(){
			$('#vitesse').load("/cgi-bin/gps/lire_vitesse");
		};	
    </script> 
	
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
			tempExt =  $('#Ext').load("/cgi-bin/temperature/tempExt");
            $('#Ext').jqxGauge({ value: tempExt });
			tempInt = $('#Inttemp').load("/cgi-bin/temperature/tempInt");
            $('#Int').jqxGauge({ value: tempInt });
			tempMot = $('#Mottemp').load("/cgi-bin/temperature/tempMot");
            $('#Mot').jqxGauge({ value: tempMot });
            $('#fixTemp').load("/cgi-bin/gps/get_fix_cgi");
            $('#netTemp').load("/cgi-bin/internet/check_internet");
			/* photoFix = $('#fixTemp').html();
			$('#Pfix').attr('src', photoFix);
            photoNet = $('#netTemp').html();
			$('#Pnet').attr('src', photoNet); */
		};	
    </script>
        
  

</head>

<body>

    <?php
  
    FUNCTION updateTrajetPHP(){
    #update pour terminé le trajet
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
        echo 'Trajet terminé!';
    }
 
  
    # Vérifie si le dernier trajet est terminé à l'allumage
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
           # Le trajet en cours n'est pas terminé
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

		// Mise à 0 des kil partiel
		$sql3 = "UPDATE kilometre SET kilometre_cumule_partiel=0 order by Id desc limit 1";
		$bdd->exec($sql3);
		
		echo '<div class="alert alert-info">
			<button class="close" data-dismiss="alert" type="button">x</button>
			AjoutÃ© avec succÃ¨s !
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
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa  fa-signal  fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>Data</strong>
                                    <span class="pull-right text-muted">
                                        <em id="netTemp"></em>
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
                                        <em id="">fixTemp</em>
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
                            <a href="index.html"><i class="fa fa-dashboard fa-fw"></i> Home</a>
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
            <div class="container-fluid">
                <div class="row-fluid">
                    <div class="col-lg-12">
                        <h1 class="page-header">Bande de chameaux !</h1>
                        <button type="button" class="pull-right glyphicon glyphicon-plus btn btn-success" data-toggle="modal" data-target="#myModal" >Ajouter un trajet</button>
                    </div>
                    <div class="col-lg-5 col-md-offset-4">
                        <h1 id="vitesse" style="font-size: 156px;">Vitesse</h1>
                    </div>
                    <div class="col-lg-12" id="temp">
                        
                        <a class="col-lg-2 col-lg-offset-2" id="Int"></a>
                        <a class="col-lg-2" id="Mot"></a>
                        <a class="col-lg-2" id="Ext"></a>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <!-- Modal ajout de trajet -->
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

    
     <!-- Script premier démarrage de la PI -->
    <script>
    function updateTrajetJS(){
     alert("<?PHP updateTrajetPHP(); ?>");
     document.getElementById(clickMe).style.visibility="hidden";
     }
    </script>

</body>

</html>
