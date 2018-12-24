<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="icon" href="images/journal.png" type="image/gif" sizes="16x16">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Saving Journal Information</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    
</head>
<body>

<?php
// store the form inputs in variables
$journal_text = filter_input(INPUT_POST, 'journal_text');
$publish_date =  filter_input(INPUT_POST, 'publish_date');
//$type =  filter_input(INPUT_POST, 'j_type');
$photo = filter_input(INPUT_POST, 'photo');

  
// add the movie id in case you are editing 

$ID_Number = NULL; 
$ID_Number = $_POST['ID_Number'];
  
//set up a flag variable 
  
$ok = true; 

//checking if name is filled in
  
if(empty($journal_text)) {
  echo '<div class="container"><div class="alert alert-danger"><center>Journal\'s text is most essential thing for publishing.!!!</center></div></div>';
  $ok = false; 
}
if(empty($publish_date)) {
  echo '<div class="container"><div class="alert alert-danger"><center>Publish date is required.</center></div></div>';
    $ok = false; 
}
// if(empty($type)) {
//   echo '<div class="container"><div class="alert alert-danger"><center>Journal Type is required for </center></div></div>';
//     $ok = false; 
// }
  
if($ok == TRUE) {

    // connecting to the database
    require_once('db.php'); 
    require_once('appvars.php'); 
    
    if(isset($_POST['submit'])){

      $photo = $_FILES['photo']['name'];
      $photo_type = $_FILES['photo']['type'];
      $photo_size = $_FILES['photo']['size']; 

      $target = UPLOADPATH . $photo;
      if(move_uploaded_file($_FILES['photo']['tmp_name'], $target)){
        echo '<div class="container"><div class="alert alert-success"><center>
    <strong>Success!</strong> Your all data including image is successfully stored in database!</center>
  </div></div>';
      }
      else{
        echo '<div class="container"><div class="alert alert-danger"><center>
    <strong>Sorry!</strong> Error saving your image!</center></div></div>';
      }

    //add this for update 
    if(!empty($ID_Number)) {
      $sql = "UPDATE journals SET journal_text = :journal_text, publish_date = :publish_date, photo = :photo WHERE ID_Number = :ID_Number";  
        
      }
      //take out else and start with insert 
     else {
      
      // set up an SQL command to save the new game
      $sql = "INSERT INTO journals (journal_text, publish_date, photo) VALUES (:journal_text, :publish_date, :photo)";
      
      }
    }

    // set up a command object
    $cmd = $conn->prepare($sql);

    // fill the placeholders with the 4 input variables
    $cmd->bindParam(':journal_text', $journal_text);
    $cmd->bindParam(':publish_date', $publish_date);
    //$cmd->bindParam(':type', $type);
    $cmd->bindParam(':photo', $photo);
  
    if(!empty($ID_Number)) {
      $cmd->bindParam(':ID_Number', $ID_Number);   
    }

    // execute the insert
    $cmd->execute();

    // disconnecting
    $cmd->closeCursor();
  }
  

?>

<div class="container" style="text-align:center;">
  <!-- Trigger the modal with a button -->
  <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal"><h2>User Guide</h2></button>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Basic Instructions for you</h4>
        </div>
        <div class="modal-body">
          <p>Here you are going to publish information of your Journal to the top demanding website..</p>
          <p>To see your submitted information and change it, you have to login before doing that.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
<hr>
<div class="container">
  <div class="btn-group btn-group-justified">
    <a href="index.php" class="btn btn-primary">Add Journal</a>
    <a href="index2.php" class="btn btn-primary">View Journal</a>
  </div>
</div>


</body>
</html>