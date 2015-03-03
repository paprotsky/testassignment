<?
   if(file_exists('connectionDB.php')) include 'connectionDB.php'; 

   $postdata = file_get_contents("php://input");
   $request = json_decode($postdata);
   $queryId = $request->queryId;

   mysql_query("DELETE FROM queries WHERE id = $queryId");
?>