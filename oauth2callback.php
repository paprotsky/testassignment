<?php
session_start();
if(file_exists('connectionDB.php')) include 'connectionDB.php';

$client_id = '911744139194-vdvvodha06dsj9fbg81g3s1osii2ccd0.apps.googleusercontent.com'; // Client ID
$client_secret = 'c2taLQJXjm3NoyRu9AsXWgHZ'; // Client secret
$redirect_uri = 'http://testassignment.zaladmin.com/oauth2callback.php'; // Redirect URI

$url = 'https://accounts.google.com/o/oauth2/auth';

if (isset($_GET['code'])) {
   $result = false;

   $params = array(
      'client_id'     => $client_id,
      'client_secret' => $client_secret,
      'redirect_uri'  => $redirect_uri,
      'grant_type'    => 'authorization_code',
      'code'          => $_GET['code']
   );

   $url = 'https://accounts.google.com/o/oauth2/token';

   $curl = curl_init();
   curl_setopt($curl, CURLOPT_URL, $url);
   curl_setopt($curl, CURLOPT_POST, 1);
   curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
   $result = curl_exec($curl);
   curl_close($curl);
   $tokenInfo = json_decode($result, true);

   if (isset($tokenInfo['access_token'])) {
      $params['access_token'] = $tokenInfo['access_token'];

      $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
      if (isset($userInfo['id'])) {
         $userInfo = $userInfo;
         $result = true;
      }
   }

   if ($result) {
      // echo "Social ID: " . $userInfo['id'] . '<br />';
      // echo "Name: " . $userInfo['name'] . '<br />';
      // echo "Email: " . $userInfo['email'] . '<br />';
      // echo "Google+: " . $userInfo['link'] . '<br />';
      // echo "Gender: " . $userInfo['gender'] . '<br />';
      // echo '<img src="' . $userInfo['picture'] . '" />'; echo "<br />";
      $_SESSION['name'] = $userInfo['name'];
      $_SESSION['googleId'] = $userInfo['id'];

      $name = $userInfo['name'];
      $email = $userInfo['email'];
      $googleId = $userInfo['id'];
      $time = date("Y-m-d H:i:s");

      $salt = '$2a$07$zjowqrlzpehyuxxqcsfeaqwertyimoxqsakmdzove';
      $hashed_password = crypt($googleId, $salt);
      $token = md5(time().$hashed_password);

      $query = mysql_query("INSERT INTO sessions (Name, GoogleId, Time, Token) VALUES ('$name','$googleId', '$time','$token')");
      $query = mysql_query("INSERT INTO customers (Name, Email, GoogleId, Time) VALUES ('$name','$email','$googleId','$time')");

      setcookie('tokentestassignment', $token, time() + 60 * 60 * 24,'/');
      echo '<script>window.location = "map.php";</script>';
   } 
}
?>