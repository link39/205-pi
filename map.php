<!DOCTYPE html>
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
    
	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
    <script type="text/javascript">
    //<![CDATA[

    var customIcons = {
      message: {
        icon: '/img/message.png'
      },
	  essence: {
        icon: '/img/essence.png'
      },
      depart: {
        icon: '/img/depart.jpg'
      },
      arrive: {
        icon: '/img/arrive.png'
      }
    };

    function load() {
	
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(45, 5),
        zoom: 6,
        mapTypeId: 'roadmap'
      });
	  
	  var flightPlanCoordinates = new Array();
	  <?php
	  if(isset($_GET['Trajet'])){
	  ?>
	  downloadUrl("mapXMLpoint.php?id=<?php echo $_GET['Trajet']?>", function(data) {
      <?php
	  }
	  else{
	  ?>
	  downloadUrl("mapXMLpoint.php", function(data) {
	  
	  <?php
	  }
	  ?>
		
		var xmlPoint = data.responseXML;
        var points = xmlPoint.documentElement.getElementsByTagName("point");
        for (var i = 0; i < points.length; i++) {
          var point = new google.maps.LatLng(
              parseFloat(points[i].getAttribute("lat")),
              parseFloat(points[i].getAttribute("lng")));
		  flightPlanCoordinates[i] = point;
        }
      });
	  alert("Bienvenue !");
   	  var flightPath = new google.maps.Polyline({
		path: flightPlanCoordinates,
		geodesic: true,
		strokeColor: '#FF0000',
		strokeOpacity: 1.0,
		strokeWeight: 2
	  });

	  flightPath.setMap(map);


      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      downloadUrl("mapXMLmarker.php?id=<?php echo $_GET['Trajet']?>", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
		  var type = "message";
		  var auteur = markers[i].getAttribute("auteur");
		  var message = markers[i].getAttribute("message");
		  var jour = markers[i].getAttribute("jour");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = "<b>" + name + "</b><br/>" + auteur + "<br/>" + message + "<br/>";
          var icon = customIcons[type] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
	  
	  
	  // Change this depending on the name of your PHP file
      downloadUrl("mapXMLcarburant.php", function(data) {
        var xmlEssence = data.responseXML;
        var essences = xmlEssence.documentElement.getElementsByTagName("essence");
        for (var i = 0; i < essences.length; i++) {
	      var type = "essence";
		  var icon = customIcons[type] || {};
          var prixlitre = essences[i].getAttribute("prixlitre");
          var kilometre = essences[i].getAttribute("kilometre");
          var date = essences[i].getAttribute("date");
          var point = new google.maps.LatLng(
              parseFloat(essences[i].getAttribute("lat")),
              parseFloat(essences[i].getAttribute("lng")));
	      var html = "<b>" + date + "</b><br/>" + prixlitre + "<br/>";
          var essence = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(essence, map, infoWindow, html);
        }
      });
      
      // Change this depending on the name of your PHP file
      downloadUrl("mapXMLdepart.php?id=<?php echo $_GET['Trajet']?>", function(data) {
        var xmlDepart = data.responseXML;
        var departs = xmlDepart.documentElement.getElementsByTagName("depart");
        for (var i = 0; i < departs.length; i++) {
	      var type = "depart";
          var date = departs[i].getAttribute("date");
		  var icon = customIcons[type] || {};
          var point = new google.maps.LatLng(
              parseFloat(departs[i].getAttribute("lat")),
              parseFloat(departs[i].getAttribute("lng")));
	      var html = "<b>Départ le " + date + "<br/>";
          var depart = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(depart, map, infoWindow, html);
        }
      });
      
      // Change this depending on the name of your PHP file
      downloadUrl("mapXMLarrive.php?id=<?php echo $_GET['Trajet']?>", function(data) {
        var xmlArrive = data.responseXML;
        var arrives = xmlArrive.documentElement.getElementsByTagName("arrive");
        for (var i = 0; i < arrives.length; i++) {
	      var type = "arrive";
          var date = arrives[i].getAttribute("date");
		  var icon = customIcons[type] || {};
          var point = new google.maps.LatLng(
              parseFloat(arrives[i].getAttribute("lat")),
              parseFloat(arrives[i].getAttribute("lng")));
	      var html = "<b>Arrivé le " + date + "</b>";
          var arrive = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(arrive, map, infoWindow, html);
        }
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }
	
	function bindInfoWindow(essence, map, infoWindow, html) {
      google.maps.event.addListener(essence, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, essence);
      });
    }
    
    function bindInfoWindow(depart, map, infoWindow, html) {
      google.maps.event.addListener(depart, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, depart);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}
	
	

    //]]>

  </script>

  

  </head>

  <body onload="load()">
	<?php
	try
	{
		$bdd = new PDO('mysql:host=localhost;dbname=bdc', 'root', 'bananapi');
	}
	catch(Exception $e)
	{
			die('Erreur : '.$e->getMessage());
	}

	$reponse = $bdd->query('SELECT * FROM Trajet');
    
    if(isset($_GET['Trajet'])){
        $date1 = $bdd->query('SELECT Date FROM kilometre WHERE id_trajet ='.$_GET['Trajet'].' ORDER BY Id DESC LIMIT 1');
        $date2 = $bdd->query('SELECT Date FROM kilometre WHERE id_trajet='.$_GET['Trajet'].' ORDER by Id LIMIT 1');
        $kilometre_trajet = $bdd->query('SELECT kilometre_cumule_partiel FROM kilometre WHERE id_trajet='.$_GET['Trajet'].' ORDER by Id DESC LIMIT 1');
        while ($donnees = $date1->fetch())
        {
            $dateTop=$donnees['Date'];
            $dateTop = new DateTime($dateTop);
        }
        while ($donnees = $date2->fetch())
        {
            $dateBottom=$donnees['Date'];
            $dateBottom = new DateTime($dateBottom);
        }
        while ($donnees = $kilometre_trajet->fetch())
        {
            $kilometreTrajet=$donnees['kilometre_cumule_partiel'];
        }
        $temps_trajet = $dateBottom->diff($dateTop); 
    }

	?>
	
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
    <div id="page-wrapper">
        <div class="container">
            <div class="row">
                <h1 class="page-header">Carte </h1>
                <form name"Formulaire">
            <p>Trajet : <select name="Trajet" id="id_trajet">
            <?php 
                while ($donnees = $reponse->fetch())
                {
                    echo "<option value='".$donnees['id_trajet']."'>".$donnees['Nom']."</option>";
                }
            ?>
            </select></p>		 
            <input type="submit" value="Afficher">
            </form>
            <p>Temps trajet : <?php print_r($temps_trajet->format('%h heures %i minutes %s secondes'));  ?></p>
            <p>Kil trajet : <?php echo $kilometreTrajet;  ?></p>
            </div>
          <div class="starter-template">
            <div id="map" style="width: 900px; height: 450px"></div>
            
            
            <!-- Affichage map -->
            
          </div>

        </div><!-- /.container -->
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
