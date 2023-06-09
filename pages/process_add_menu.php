<?php
include('../config.php');

$config = new Config();
$conn = $config->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($image_tmp, '../images/' . $image);

    $sql = "INSERT INTO menu (name, description, price, image) VALUES ('$name', '$description', '$price', '$image')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: admin.php');
        exit;
    } else {
        echo 'Failed to add menu.';
    }
}
?>
