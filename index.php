                       
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
         "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Handla</title>
  <meta name="viewport" content="width=devicewidth; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;"/>
  <link rel="apple-touch-icon" href="iui/iui-logo-touch-icon.png" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <link rel="stylesheet" href="iui/iui.css" type="text/css" />

  <link rel="stylesheet" title="Default" href="iui/t/default/default-theme.css"  type="text/css"/>
  <script type="application/x-javascript" src="iui/iui.js"></script>
  <script type="text/javascript">
    iui.animOn = true;
  </script>
</head>

<body>
    <div class="toolbar">
        <h1 id="pageTitle"></h1>
        <a id="backButton" class="button" href="#"></a>
    </div>
    
    <form id="search" title="Handlingslista" class="panel" action="index.php" method="POST" selected="true">
        <fieldset>

            <div class="row">
                <label>Artikel</label>
                <input type="text" name="item" value=""/>
            </div>

	    <div class="row">
		<label for="category">Kategori</label>
		<select id="category" name="category" class="panel">
		<option value="1">Grönt</option>
		<option value="2">Kött</option>
		<option value="3">Kryddor</option>
		<option value="4" selected>Mejeri</option>
		<option value="5">Bröd</option>
		<option value="6">Ris och pasta</option>
		<option value="7">Fryst</option>
		<option value="8">Hushåll</option>
		<option value="9">Barn</option>
		<option value="10">Övrigt</option>
		<option value="11">Detalj</option>
		</select>
	    </div>

        </fieldset>
        <a class="whiteButton" type="submit" href="#">Add</a>


<?php
error_reporting(E_ALL ^ E_DEPRECATED);
// read

	    
	    
//$item = htmlspecialchars($_POST["item"]);
$item = isset($_POST["item"]) ? $_POST["item"] : "";
$location = isset($_POST["location"]) ? $_POST["location"] : "";
$category = isset($_POST["category"]) ? $_POST["category"] : "";
$remove = isset($_GET["remove"]) ? $_GET["remove"] : "";	    
//$remove= htmlspecialchars($_GET["remove"]);
	    
echo $item;
echo $location;
	    echo $category;
	    echo $remove;

// Connecting, selecting database

$dbhost = getenv("MYSQL_SERVICE_HOST");
$dbport = getenv("MYSQL_SERVICE_PORT");
$dbuser = "user0O1";
$dbpwd = "BTJQ1j01B4egRhMX";
$dbname = "handla";
$connection = new mysqli($dbhost, $dbuser, $dbpwd, $dbname);
if ($connection->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
} else {
    printf("Cönnected to the database");
}
	    
// Create the empty table if it does not exist already	        
mysqli_query($connection,"CREATE TABLE items(id INT NOT NULL AUTO_INCREMENT,PRIMARY KEY(id),item VARCHAR(100),category INT");	    
	       

// Add new item if any
//if ( $item != "" ) {
//  $query = "INSERT INTO items VALUES ('','$item','$category')";
//  $result = mysqli_query($connection, $query) or die('Query failed: ' . mysql_error());
//}
	    
// Add new item if any
if ( $item != "" ) {
  $query = "INSERT INTO items VALUES ('','$item','$category')";
  mysqli_query($connection, $query);
}

// Remove any items if needed
if ( $remove != "" ) {
  $query = "DELETE from items WHERE id=$remove";
  $result = mysqli_query($connection, $query) or die('Query failed: ' . mysql_error());
}
   

// List items in shopping list
//$query = "SELECT id, item, category FROM items ORDER BY category";
//$result = mysqli_query($connection, $query) or die('Query failed: ' . mysql_error());

$result = mysqli_query($connection, "SELECT id, item, category FROM items ORDER BY category");
	    
echo "<br>";
echo "<fieldset>";
while ($line = mysqli_fetch_array($result, MYSQLI_ASSOC))	
{
  echo "<div class=\"row\">";
  echo "<label>$line[item]</label>";
  echo "<a class=\"button$line[category]\" href=\"index.php?remove=$line[id]\"></a>";
  echo "</div>";
}
echo "</fieldset>";

// Free resultset
mysqli_free_result($result);
// Closing connection
mysqli_close($link);

?>

</form>

</body>
</html>
