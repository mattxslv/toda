<?php
$connection = mysqli_connect("localhost", "root", "", "adminpanel");

// Check connection
if (!$connection) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adminpanel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "adminpanel";

// Create connection
$connection = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
<?php
$connection = mysqli_connect("localhost", "root", "", "adminpanel");

if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}
?>