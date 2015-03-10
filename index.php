<?
   session_start();
   if(file_exists('connectionDB.php')) include 'connectionDB.php';

   if(isset($_COOKIE['tokentestassignment'])){
      header('Location: map.php');
   }
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="UTF-8">
      <link rel="shortcut icon" href="img/title.png">
      <title>Test Assignment</title>

      <script src="js/jquery-2.1.1.min.js"></script>

      <link href="css/bootstrap.min.css" rel="stylesheet">
      <link href="font-awesome-4.3.0/css/font-awesome.css" rel="stylesheet">
   </head> 
   <body>
      <div class="navbar navbar-default navbar-static-top" role="navigation" style="background-color: rgba(248,248,248,0.8)">
         <div class="container">
            <div class="pull-right"><br>
               <?php
                  $client_id = '911744139194-dfg34b5nglna16c3t1f7k40oq4s5a8dd.apps.googleusercontent.com'; // Client ID
                  $client_secret = '8oVBldxeFVrpJTI15RLGrbTm'; // Client secret
                  $redirect_uri = 'http://testassignment.com/oauth2callback.php'; // Redirect URI

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
         <footer>
            <p>&copy; roman@paprotsky.com</p>
         </footer>
      </div>
      <script src="js/bootstrap.min.js"></script>
      <script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
   </body>
</html>
<style type="text/css">
   body {
      background: url(img/map.png);
      background-size: 100% ;
      background-repeat: no-repeat;
   }
   footer{
      color: #ECF0F1;
      bottom: 0;
      left: 15px;
      position: fixed;
   }
   .googleBtn{
      color: #fff;
      background-color: #dd4b39;
      margin-top: -15px;
   }
</style>
