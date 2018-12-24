<?php ob_start(); 

$journal_ID = $_GET['ID_Number'];

//connect

require_once('db.php'); 

// set up sql query 

$sql = "DELETE FROM journals WHERE ID_Number = $journal_ID";

//prepare 

$cmd = $conn->prepare($sql); 

//bind 

$cmd->bindParam(':ID_Number', $ID_Number, PDO::PARAM_INT);

//execute 

$cmd->execute(); 

// close the connection 

$conn = NULL; 

header('location:home.php'); 


ob_flush(); 

?>