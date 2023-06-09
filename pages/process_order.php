<?php
include('../config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $menuId = $_POST['menu'];

    $sql = "INSERT INTO orders (name, email, menu_id) VALUES ('$name', '$email', '$menuId')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo 'Order placed successfully.';
    } else {
        echo 'Failed to place order.';
    }
}
?>
