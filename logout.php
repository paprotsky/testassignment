<?php
   session_start();
   session_destroy();
   unset($_COOKIE['tokentestassignment']);
   setcookie('tokentestassignment', '', time()-10,'/');
   header("Location: index.php"); 
?> 