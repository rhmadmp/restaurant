<?php
include('../config.php');

$config = new Config();
$conn = $config->getConnection();

$order_id = $_GET['id'];

$sql = "DELETE FROM orders WHERE id='$order_id'";
if (mysqli_query($conn, $sql)) {
    header('Location: user.php');
    exit;
} else {
    echo 'Error: ' . mysqli_error($conn);
}
?>
