<?
   session_start();
   $googleId = $_SESSION['googleId'];
   $time = date("Y-m-d H:i:s");

   if(file_exists('connectionDB.php')) include 'connectionDB.php';

   require_once("FoursquareAPI.class.php");
   // Set your client key and secret
   $client_key = "ZWWZX0XDVX4QR4JEEGIY2ORS5R0Y2L24OS5NQNA0TIT4BVBB";
   $client_secret = "3PDMBFGRQOXBWJ5RIG1VOAD2HGFMTXBT2EDMN30FHJMFBXPF";
   $foursquare = new FoursquareAPI($client_key,$client_secret);

   $postdata = file_get_contents("php://input");
   $request = json_decode($postdata);
   $lat = $request->lat;
   $lng = $request->lng;
   $query = $request->query;

   $params = array("ll"=>"$lat,$lng","query"=>"$query");
   $data = $foursquare->GetPublic("venues/search",$params);
   $json = json_decode($data, true);

   for ($i = 0; $i < sizeof($json['response']['venues']); $i++) {
      if ($json['response']['venues'][$i]['location']['distance'] > $distance) {
         $distance = $json['response']['venues'][$i]['location']['distance'];
      } 
   } 

   mysql_query("INSERT INTO queries (GoogleId, Latitude, Longtitude, Distance, Query, Time) VALUES ('$googleId','$lat', '$lng', '$distance', '$query', '$time')");

   echo $data;
?>