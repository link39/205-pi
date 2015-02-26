<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>205-PI Map</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/starter-template.css" rel="stylesheet">

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
		$bdd = new PDO('mysql:host=localhost;dbname=Voiture', 'root', 'bananapi');
	}
	catch(Exception $e)
	{
			die('Erreur : '.$e->getMessage());
	}

	$reponse = $bdd->query('SELECT * FROM Trajet');
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
            <li><a href="consommation.php">Consommation</a></li>
            <li class="active"><a href="#">Carte</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="starter-template">
		<div id="map" style="width: 900px; height: 450px"></div>
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
		
		<!-- Affichage map -->
		
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>
