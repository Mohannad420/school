<?php
$dsn = 'mysql:host=localhost;dbname=test'; // Data Source Name 
$user = 'root'; // The User To Connect
$pass = ''; // password Of This User 

try {
    $conn = new PDO($dsn, $user , $pass); // Start A New Connectiom=n With PDO Class
    // echo 'connect succsess' ;
}
catch(PDOException $e) {
    echo 'Failed' . $e->getMessage();
}


?>