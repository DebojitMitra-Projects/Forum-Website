<!--Database Connection Page -->
<?php
$servername = 'localhost';
$username= 'root';
$password= '';
$database= 'idiscuss';

$conn = mysqli_connect($servername, $username, $password, $database);
 
if (!$conn)
    die("Could not connect to the database".mysql_connect_error());

?>