<?
   session_start();
   if(file_exists('connectionDB.php')) include 'connectionDB.php';

   if(isset($_COOKIE['tokentestassignment'])){
      $token = $_COOKIE['tokentestassignment'];
      $tokenQuery = mysql_query("select * from `sessions` where Token = '$token'")
         or die(mysql_error());
      while($resToken = mysql_fetch_array($tokenQuery)){
         $_SESSION['name'] = $resToken['Name'];
         header('Location: map.php');
      }
   }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <link rel="shortcut icon" href="img/title.png">
      <title>Test Assignment</title>

      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="font-awesome-4.3.0/css/font-awesome.css" rel="stylesheet">
   </head> 
   <body>
      <div class="navbar navbar-default navbar-static-top" role="navigation" style="background-color: rgba(248,248,248,0.8)">
         <div class="container">
            <div class="pull-right"><br>
               <?php
                  $client_id = '911744139194-vdvvodha06dsj9fbg81g3s1osii2ccd0.apps.googleusercontent.com'; // Client ID
                  $client_secret = 'c2taLQJXjm3NoyRu9AsXWgHZ'; // Client secret
                  $redirect_uri = 'http://testassignment.zaladmin.com/oauth2callback.php'; // Redirect URI

                  $url = 'https://accounts.google.com/o/oauth2/auth';

                  $params = array(
                     'redirect_uri'  => $redirect_uri,
                     'response_type' => 'code',
                     'client_id'     => $client_id,
                     'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
                  );

                  echo '<a class="btn googleBtn" href="' . $url . '?' . urldecode(http_build_query($params)) . '" role="button"><i class="fa fa-google-plus fa-lg"></i>&nbsp; Sign in with Google</a>';
                  ?>
            </div>
         </div>
      </div>
      <script src="js/bootstrap.min.js"></script>
      <script src="js/jquery-2.1.1.min.js"></script>
   </body>
</html>
<style type="text/css">
   .googleBtn{
      color: #fff;
      background-color: #dd4b39;
      margin-top: -13px;
   }
   body {
    background: url(img/map.jpg);
    background-size: 100% ;
    background-repeat: no-repeat;
   }
</style>
