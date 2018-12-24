<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Add New INSTAPic! </title>
<link rel="icon" href="images/journal.png" type="image/gif" sizes="16x16">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">
<style>
  .photocontainer {
    display:flex; 
    margin: 0 auto;
    flex-direction: row; 
    justify-content:space-around;
    flex-wrap: wrap; 
  }
  
  h1{
    font-family: 'Pacifico', cursive;
  }
  
  header {
    text-align:center; 
    margin-bottom: 25px; 
  }
  
  main {
    width: 90%; 
    margin-left: auto; 
    margin-right: auto; 
    border: 1px solid #999;
    border-radius: 25px; 
    padding: 15px; 
  }
  
  header a {
    color: #EE12E0; 
    font-size: 18px; 
    text-transform: lowercase; 
  }
</style>
</head>

<body>
<?php

//require the files we need for db connection and application constants 
require_once('appvars.php');
require_once('db.php'); 


if(isset($_POST['submit'])) {
  
  //use $_FILES to grab the image name
  $photo = $_FILES['photo']['name'];
  $photo_type = $_FILES['photo']['type'];
  $photo_size = $_FILES['photo']['size']; 
    
    
  if(!empty($photo)){
    //checking for the right filetype & size 
    if ((($photo_type == 'image/gif') || ($photo_type == 'image/jpeg') || ($photo_type == 'image/jpg') || ($photo_type == 'image/png')) && ($photo_size > 0) && ($photo_size <= MAXFILESIZE)) {
      //making sure no upload errors 
      if ($_FILES['photo']['error'] == 0) {
      
      $target = UPLOADPATH . $photo; 
      
      if(move_uploaded_file($_FILES['photo']['tmp_name'], $target))  
      

      //set up the query 
      $sql = "INSERT INTO books (photo) VALUES (:photo)";
            
      //prepare 
      $cmd = $conn->prepare($sql);
      
      //bind
      $cmd->bindParam(':photo', $photo); 
        
      //execute 
      $cmd->execute(); 
        
      //close the db connection 
      
      $cmd->closeCursor(); 
      

      //**************** */
      // $name = ""; 
      // $description = ""; 
      // $photo = ""; 

      }
      else {
        echo '<p> There was a problem uploading your file</p>'; 
        }
    }
    else {
      echo '<p> You must submit either a png, jpeg, jpg or a png and your file cannot be greater than 32kb'; 
      
    }
    
  }
  
  else {
    echo '<p> Please enter all the info! </p>'; 
  }

}

?>
<main class="container">
  <!-- <header>
    <h1> Add A New Pic! </h1>
     <a href="index.php"> View All The Pics </a>
  </header> -->

  <!-- don't forget to add enctype to your form! -->
  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <div class="form-group">
      <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAXFILESIZE; ?>">

      <label for="name"> Description </label>
      <input type="text" name="description" value="<?php if (!empty($name)) echo $name;?>" class="form-control">
    </div>
    

    <div class="form-group">
      <label for="photo"> Photo:</label>
      <input type="file" id="photo" name="photo"/>
    </div>
    <br/>
    <input type="submit" value="Add" name="submit" class="btn btn-default"/>
    </div>

  </form>
  </main>
</body>
</html>