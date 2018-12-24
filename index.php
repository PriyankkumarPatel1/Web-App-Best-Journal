<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Book Lovers</title>
    <link rel="icon" href="images/journal.png" type="image/gif" sizes="16x16">
      <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</head>
<body>
    
<?php
  
  //initializing variables 
  $ID_Number = null;
  $journal_text = null; 
  $publish_date = null; 
  $type = null;
  //$photo = null;
  
 if(!empty($_GET['ID_Number'])  && (is_numeric($_GET['ID_Number'])))
  {
    //grab the movie id from the URL string 
    $ID_Number = $_GET['ID_Number'];
    
    //connect to the db
    require('db.php');
    
    //set up your query 
    $sql = "SELECT * FROM journals WHERE ID_Number = :ID_Number";
    
    //prepare 
    $cmd = $conn->prepare($sql);
    
    //bind 
    $cmd->bindParam(':ID_Number', $ID_Number);
    
    //execute 
    $cmd->execute(); 
    
    //use fetchAll method to store info in an array 
    $journals = $cmd->fetchAll(); 
    
    //loop through array using foreach and set variables
    foreach ($journals as $journal) {
      $journal_text = $journal['journal_text']; 
      $publish_date = $journal['publish_date'];
      //$type = $journal['type'];
      //$photo = $journal['photo'];
    }
    
    //close the database connection 
    
    $conn = null; 
  }

?>

<!-- HTML form to allow uesr to input data -->
  <div class="container">
     <h1> Top Journals </h1>
     <!--link to database information-->
     <a href="index2.php"><button type="submit" class="btn btn-primary"> View All Journals </button></a><hr>
                     
     <form method="post" action="save_journal.php" enctype="multipart/form-data">
      
        <div class="form-group">
          <label> Text of Journal: </label>
          <input type="textarea" rows="7" columns="50" name="journal_text" class="form-control" value="<?php echo $journal_text ?>">
        </div> <hr>
       
        <div class="form-group">
          <label> Date of Publish: </label>
          <input type="text" name="publish_date" class="form-control"  value="<?php echo $publish_date ?>">
        </div> <hr>

        <!-- <div class="form-group">
          <label> Type of Journal: </label>
          <input type="text" name="j_type" class="form-control"  value="<?php echo $type ?>">
           <select type="text" name="type" class="form-control"  value="<?php echo $publish_date ?>">
            <option value="1">academic/scholarly</option>
            <option value="2">Trade </option>
            <option value="3">Current affairs/opinion</option>
            <option value="4">Popular</option>
            <option value="5">Meditation</option>
          </select>
        </div> -->
       
        <div class="form-group">
          <label for="photo"> Photo:</label>
          <input type="file" id="photo" name="photo" class="form-control">
        </div><hr>

      <input name="ID_Number" type="hidden" value="<?php echo $ID_Number ?>">
      <input type="submit" name="submit" value="Publish on Top website" class="btn btn-primary">
          
     </form>

  </div>

</body>
</html>