
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
 
    <title>205-PI Temperature</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/starter-template.css" rel="stylesheet">
	
	<!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

	<!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
  </head>

  <body>
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
            <li><a href="index.html">Home</a></li>
            <li><a href="entretien.php">Entretien</a></li>
            <li><a href="carnet.php">Carnet de bord</a></li>
            <li><a href="consommation.php">Consommation</a></li>
            <li class="active"><a href="temperature.php">Temperature</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				Area Chart Example
			</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<div id="chartint"></div>
			</div>
			<!-- /.panel-body -->
		</div>
	</div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/jquery-ui.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    
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

                    $reponse = $bdd->query('SELECT Date(Date) AS date,MIN(interieur) as min ,MAX(interieur) AS max FROM kilometre WHERE YEAR(Date) = "2015" GROUP BY Date(Date)');
                    $rows = array();
                    while ($donnees = $reponse->fetch())
                    {	
                        $rows[] = $donnees;
                    }
                    echo json_encode($rows);
                    $reponse->closeCursor();

        ?>,
          xkey: 'date',
          ykeys: ['min', 'max'],
          labels: ['Min', 'Max']
});
    </script> 
  </body>
</html>
