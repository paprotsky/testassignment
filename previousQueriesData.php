<?
   session_start();
   if(file_exists('connectionDB.php')) include 'connectionDB.php';

   $googleId = $_SESSION['googleId'];
 
   class Query{
      public $id;
      public $lat;
      public $lng;
      public $distance;
      public $query;
      public $time;
   }  
   $arrayOfQuaries = array();

   $queries = mysql_query("SELECT * from queries where GoogleId = $googleId")
   or die(mysql_error());
   while($previousQueries = mysql_fetch_array($queries)){
      $previousQuery = new Query();
      $previousQuery->id = $previousQueries['Id'];
      $previousQuery->lat = $previousQueries['Latitude'];
      $previousQuery->lng = $previousQueries['Longtitude'];
      $previousQuery->distance = $previousQueries['Distance'];
      $previousQuery->query = $previousQueries['Query'];
      $date = strtotime($previousQueries['Time']);
      $previousQuery->time = date('M d H:i',$date);
      $arrayOfQuaries[] = $previousQuery; 
   }

   echo json_encode($arrayOfQuaries);
?>