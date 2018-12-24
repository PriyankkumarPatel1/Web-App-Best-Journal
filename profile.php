<?php

	require_once("session.php");
	
	require_once("class.user.php");
	$auth_user = new USER();
	
	
	$user_id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM users WHERE user_id=:user_id");
	$stmt->execute(array(":user_id"=>$user_id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="icon" href="images/journal.png" type="image/gif" sizes="16x16">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen"> 
<link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> 
<script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="style.css" type="text/css"  />
<title>welcome - <?php print($userRow['user_email']); ?></title>
</head>

<body>


<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://www.codingcage.com"></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
			  <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="#"><span class="glyphicon glyphicon-user"></span>&nbsp;Photo Library</a></li>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

	<div class="clearfix"></div>
	
    <div class="container-fluid" style="margin-top:80px;">
	
    <div class="container">
    
    	<label class="h5">welcome : <?php print($userRow['user_name']); ?></label>
      <hr />
        
        <h2>
        <a href="home.php"><span class="glyphicon glyphicon-home"></span> home</a> &nbsp; 
        <a href="profile.php"><span class="glyphicon glyphicon-picture"></span> Photo Library</a></h2>
       	<hr />
    
    </div>

</div>

<?php
   
   ob_start(); // turn on the output buffering
   
   try { // this will execute and if any error occurs then the catch block will be execute excepting remaining code to be execute.
   
   //access the database
   
   require('db.php');
   require_once('appvars.php');

   //set up our SQL query 
   
   $sql = "SELECT * FROM books";
   
   //prepare
   
   $cmd = $conn->prepare($sql);
   
   //run that query 
   
   $cmd->execute(); 
   
   //use fetchAll to store results 
   
   $books = $cmd->fetchAll(); 
   
   //echo out table header 
   
   echo '<div class="container"><table class="table table-striped">
           <thead>
               <th> book_title </th>
               <th> Photo </th>
           </thead>
         <tbody>';
   
   //loop through data and create a new table row for each record 
   
   foreach ($books as $book) {
     echo '<tr><td>' . $book['book_title'] .
     '</td><td><img height="300" width="auto" class="img-rounded" src="'. UPLOADPATH  . $book['photo'] . '"></td></tr>';
   }
   
   echo '</div></tbody></table>';
   
   //close the database connection 
   
   $conn = NULL; 
     
   }
   catch(Exception $e) {
     //send an email to the app admin 
     mail('pppriyank157@gmail.com', 'Book Database Problems!!!', $e);
     
     header('location:error.php');
     
   }
   
   ob_flush(); // send the output buffer

   ?>
 
 </div>


<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>