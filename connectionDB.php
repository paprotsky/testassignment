<?php
   $link = mysql_connect("localhost", "roman", "paprotsky")
    or die("Could not connect: " . mysql_error());
   mysql_select_db("testassignment", $link) or die ('Can\'t use bloginfo : ' . mysql_error());

   mysql_query("SET NAMES 'utf8';"); 
   mysql_query("SET CHARACTER SET 'utf8';"); 
   mysql_query("SET SESSION collation_connection = 'utf8_general_ci';"); 
?>