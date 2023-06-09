<?php require_once('../config.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" type="text/css" href="css\style.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container_menu">
        <?php
        $config = new Config(); // Membuat instance dari kelas Config
        $connection = $config->getConnection(); // Mendapatkan koneksi database

        $sql = "SELECT * FROM menu";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="menu-item">';
                echo '<img src="../images/' . $row['image'] . '" alt="' . $row['name'] . '">';
                echo '<h3>' . $row['name'] . '</h3>';
                echo '<p>' . $row['description'] . '</p>';
                echo '<p>Harga: Rp ' . number_format($row['price'], 0, ',', '.') . '</p>';
                echo '<a href="order.php?id=' . $row['id'] . '">Order</a>';
                echo '</div>';
            }
        } else {
            echo '<p>No menu available</p>';
        }
        ?>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
