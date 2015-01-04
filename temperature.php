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
				<div id="morris-area-chart"></div>
				<div class="col-lg-8 col-md-8">
					<div class="box">
					<div class="box-header">
					<h2>tickets</h2>
					</div>
					<div class="box-content" style="height:304px">
					<div id="stats-chart2" class="col-lg-12" style="height: 290px; padding: 0px;">
					<canvas class="flot-base" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 700px; height: 290px;" width="700" height="290"></canvas>
					<div class="flot-text" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; font-size: smaller; color: rgb(84, 84, 84);">
					<div class="flot-x-axis flot-x1-axis xAxis x1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 55px; text-align: center;">2</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 100px; text-align: center;">4</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 145px; text-align: center;">6</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 191px; text-align: center;">8</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 233px; text-align: center;">10</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 279px; text-align: center;">12</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 324px; text-align: center;">14</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 369px; text-align: center;">16</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 415px; text-align: center;">18</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 460px; text-align: center;">20</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 505px; text-align: center;">22</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 551px; text-align: center;">24</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 596px; text-align: center;">26</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 642px; text-align: center;">28</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; max-width: 43px; top: 274px; left: 687px; text-align: center;">30</div>
					</div>
					<div class="flot-y-axis flot-y1-axis yAxis y1Axis" style="position: absolute; top: 0px; left: 0px; bottom: 0px; right: 0px; display: block;">
					<div class="flot-tick-label tickLabel" style="position: absolute; top: 261px; left: 24px; text-align: right;">0</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; top: 209px; left: 6px; text-align: right;">2500</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; top: 157px; left: 6px; text-align: right;">5000</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; top: 104px; left: 6px; text-align: right;">7500</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; top: 52px; left: 0px; text-align: right;">10000</div>
					<div class="flot-tick-label tickLabel" style="position: absolute; top: 0px; left: 0px; text-align: right;">12500</div>
					</div>
					</div>
					<canvas class="flot-overlay" style="direction: ltr; position: absolute; left: 0px; top: 0px; width: 700px; height: 290px;" width="700" height="290"></canvas>
					</div>
					</div>
					</div>
					</div>
				</div>
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
	<!-- Morris Charts JavaScript -->
    <script src="js/plugins/morris/raphael.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/morris/morris-data.js"></script>
  </body>
</html>
