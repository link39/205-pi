
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
    
    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

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
    
    <!-- Script pour la PI  -->
	
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
			/* photoFix = $('#fixTemp').html();
			$('#Pfix').attr('src', photoFix);
            photoNet = $('#netTemp').html();
			$('#Pnet').attr('src', photoNet); */
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
                                        <em id="fixTemp"></em>
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
                <div class="row-fluid" style="margin-top:20px;">
                    <div class="col-lg-12">
                        <h1 class="page-header">Dashboard</h1>
                    </div>
                </div>
                <div class="row-fluid">
                
                
                <div>

                  <!-- Nav tabs -->
                  <ul class="nav nav-pills" role="tablist">
                    <li role="presentation" class="active"><a href="#Températures" aria-controls="Températures" role="tab" data-toggle="tab">Températures</a></li>
                    <li role="presentation"><a href="#Kilomètres" aria-controls="Kilomètres" role="tab" data-toggle="tab">Kilomètres</a></li>
                  </ul>

                  <!-- Tab panes -->
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="Températures">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Températures Intérieur
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="chartint"></div>
                            </div>
                            <!-- /.panel-body -->
                            <div class="panel-heading">
                                Températures Exterieur
                            </div>
                            <div class="panel-body">
                                <div id="chartext"></div>
                            </div>
                            <div class="panel-heading">
                                Températures Moteur
                            </div>
                            <div class="panel-body">
                                <div id="chartmot"></div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane active" id="Kilomètres">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                    Kilomètres par trajet
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="chartkiltraj"></div>
                            </div>
                            <div class="panel-heading">
                                    Kilomètres par jours
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="chartkiljour"></div>
                            </div>
                            <div class="panel-heading">
                                    Kilomètres par Personne
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <div id="chartpersonne"></div>
                            </div>
                        </div>
                    </div>
                  </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    
    	<!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>    
    <script>
        new Morris.Bar({
          element: 'chartint',
          data :
          <?php
                    try
                    {
                        $bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
                    }
                    catch(Exception $e)
                    {
                            die('Erreur : '.$e->getMessage());
                    }

                    $reponse = $bdd->query('SELECT Date(Date) AS date,MIN(interieur) as min ,MAX(interieur) AS max, AVG(interieur) AS moy FROM kilometre WHERE YEAR(Date) = "2015" GROUP BY Date(Date)');
                    $rows = array();
                    while ($donnees = $reponse->fetch())
                    {	
                        $rows[] = $donnees;
                    }
                    echo json_encode($rows);
                    $reponse->closeCursor();

        ?>,
          xkey: 'date',
          ykeys: ['min', 'moy','max'],
          labels: ['Min', 'Moy', 'Max']
    });
    </script>
    <script>
        new Morris.Bar({
          element: 'chartext',
          data :
          <?php
                    try
                    {
                        $bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
                    }
                    catch(Exception $e)
                    {
                            die('Erreur : '.$e->getMessage());
                    }

                    $reponse = $bdd->query('SELECT Date(Date) AS date,MIN(exterieur) as min ,MAX(exterieur) AS max, AVG(exterieur) AS moy FROM kilometre WHERE YEAR(Date) = "2015" GROUP BY Date(Date)');
                    $rows = array();
                    while ($donnees = $reponse->fetch())
                    {	
                        $rows[] = $donnees;
                    }
                    echo json_encode($rows);
                    $reponse->closeCursor();

        ?>,
          xkey: 'date',
          ykeys: ['min', 'moy','max'],
          labels: ['Min', 'Moy', 'Max']
    });
    </script> 
    <script>    
        new Morris.Bar({
          element: 'chartkiltraj',
          data :
          <?php
                    try
                    {
                        $bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
                    }
                    catch(Exception $e)
                    {
                            die('Erreur : '.$e->getMessage());
                    }

                    $reponse = $bdd->query('SELECT Date,MAX(kilometre_cumule_partiel) AS kil, id_trajet FROM kilometre WHERE (Year(Date) = "2015") GROUP BY id_trajet');
                    $rows = array();
                    while ($donnees = $reponse->fetch())
                    {	
                        $rows[] = $donnees;
                    }
                    echo json_encode($rows);
                    $reponse->closeCursor();

        ?>,
          xkey: 'id_trajet',
          ykeys: ['kil'],
          labels: ['Kil']
    });
    </script> 
    
</body>
</html>








