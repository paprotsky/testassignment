<?
   session_start();

   if(!isset($_COOKIE['tokentestassignment'])){
      header('Location: index.php');
   } else {
      if(file_exists('connectionDB.php')) include 'connectionDB.php';
      $token = $_COOKIE['tokentestassignment'];
      $tokenQuery = mysql_query("select * from `sessions` where Token = '$token'")
         or die(mysql_error());
      $_SESSION['name'] = mysql_result($tokenQuery,0,1);
      $_SESSION['googleId'] = mysql_result($tokenQuery,0,2);
   }

   if(file_exists('connectionDB.php')) include 'connectionDB.php';
   require_once("FoursquareAPI.class.php");
   // Set your client key and secret
   $client_key = "ZWWZX0XDVX4QR4JEEGIY2ORS5R0Y2L24OS5NQNA0TIT4BVBB";
   $client_secret = "3PDMBFGRQOXBWJ5RIG1VOAD2HGFMTXBT2EDMN30FHJMFBXPF";
   // Load the Foursquare API library

   if($client_key=="" or $client_secret=="")
   {
      echo 'Load client key and client secret from <a href="https://developer.foursquare.com/">foursquare</a>';
      exit;
   }

   $foursquare = new FoursquareAPI($client_key,$client_secret);
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <link rel="shortcut icon" href="img/title.png">
      <title>Test Assignment</title>
      <script src="js/jquery-2.1.1.min.js"></script>
      <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.28/angular.min.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.3.14/angular-sanitize.js"></script>
      <script type="text/javascript" src="js/ng-csv.js"></script>
      <script type="text/javascript" src="js/app.js"></script>

      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="font-awesome-4.3.0/css/font-awesome.css" rel="stylesheet">
   </head> 
   <body ng-app="foursquareApp" ng-controller="VenuesListCtrl">
      <div class="container marketing">
         <div class="col-md-12"><br>
            <div class="pull-right"><br>        
               <div class="dropdown">
                  <a id="dLabel" role="button" style="cursor:pointer" data-toggle="dropdown" data-target="#">
                     <?php echo $_SESSION['name'];?>
                  </a>
                  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                     <li>
                        <a href="logout.php"><button class="btn btn-danger" style="width:100%">Sign out</button></a>
                     </li>
                  </ul>
               </div><br>
            </div>
            <br><br><br>
            <table class="table table-hover">
               <tbody ng-cloak>
                  <tr ng:repeat="i in previousQueries">
                     <td><i class="fa fa-trash-o fa-lg" ng-click="deleteQuery(i.id)" style="cursor: pointer"</i></td>
                     <td>{{i.query}}</td>
                     <td>{{i.lat}}</td>
                     <td>{{i.lng}}</td>
                     <td>{{i.distance | distance}}</td>
                     <td>{{i.time}}</td>
                  </tr>
               </tbody>
            </table>

            <div class="input-group">
               <input type="text" class="form-control" name="query" ng-enter="searchData()" ng-keypress="hitEnter($event)" ng-model="query" placeholder="I'm looking for...">
               <span class="input-group-btn">
                  <button class="btn btn-primary" ng-click="searchData()" type="button">Search!</button>
               </span>
            </div>
            <br><br>
            <div class="thumbnail">
               <div id="map-canvas"></div>
            </div>
            <div>
               <div class="panel panel-default">
                  <div class="panel-heading">
                     <button class="btn btn-warning pull-right" ng-csv="getCsvData()" csv-header="['Name', 'City', 'Street Address', 'Latitude', 'Longtitude']" filename="venues.csv" field-separator="," type="button">Export to CSV</button>
                     <label ng-cloak>Venues <span class="badge" style="background-color: #777">{{venuesQuantity}}</span></label>
                  </div>
                  <table class="table table-hover table-striped">
                     <thead>
                        <tr>
                           <th>Name</th>
                           <th>City</th>
                           <th>Street Address</th>      
                           <th>Latitude</th>
                           <th>Longtitude</th>
                        </tr>
                     </thead>
                     <tbody ng-cloak>
                        <tr ng-repeat="i in foundVenues.response.venues">
                           <td>{{i.name}}</td>
                           <td>{{i.location.city}}</td>
                           <td>{{i.location.address}}</td>
                           <td>{{i.location.lat}}</td>
                           <td>{{i.location.lng}}</td>
                        </tr>
                     </tbody>
                  </table>
               </div>
            </div>
            <br><hr>
            <footer>
              <p>&copy; roman@paprotsky.com</p>
            </footer><br>
         </div>
      </div>
      <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>
<style type="text/css">
   #map-canvas {
     width: 100%;
     height: 500px;
   }
   .btn-warning{
      margin-top: -5px;
   }
</style>
