<?php
   // make a connection with database 
   $conn = new PDO('mysql:host=localhost ;dbname=patel_practice', 'root', '');
    //set up the error mode for exception handling 
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
    