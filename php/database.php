<?php
$car_showroom = 'car_showroom';  

$username = 'root'; 
$password = '';    

try {
    $conn = new PDO("mysql:host=localhost;dbname=$car_showroom", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    error_log($e->getMessage(), 3, 'error_log.txt');
    die("Connection failed. Please check the error log for details.");
}
?>
