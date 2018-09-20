       <?php
     
     require("phpsqlinfo_dbinfo.php");
  
  // Gets data from URL parameters.
  $name = $_GET['name'];
  $address = $_GET['address'];
  $lat = $_GET['lat'];
  $lng = $_GET['lng'];
  $type = $_GET['type'];
  
  // Opens a connection to a MySQL server.
  $connection=mysqli_connect("localhost", $username, $password,$database);
  if (!$connection) {
    die('Not connected : ' . mysqli_error());
  }
  
  // Sets the active MySQL database.
  //$db_selected = mysqli_select_db($database, $connection);
  //if (!$db_selected) {
   // die ('Can\'t use db : ' . mysqli_error());
  //}
  
  // Inserts new row with place data.
  $query = sprintf("INSERT INTO markers " .
           " (id, name, address, lat, lng, type ) " .
           " VALUES (NULL, '%s', NOW(), '%s', '%s', '%s');",
           $name,
           $lat,
           $lng,
           $type);
  
  $result = mysqli_query($connection,$query);
  
  if (!$result) {
    die('Invalid query: ' . mysqli_error());
  }
  
  ?>