<?php require_once('../config.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container">
        <h1>Admin</h1>
        <a href="add_menu.php">Tambah Menu</a>
        <table>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Action</th>
            </tr>
            <?php
            $config = new Config();
            $conn = $config->getConnection();

            $sql = "SELECT * FROM menu";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['description'] . '</td>';
                    echo '<td>' . $row['price'] . '</td>';
                    echo '<td>' . $row['image'] . '</td>';
                    echo '<td><a href="edit_menu.php?id=' . $row['id'] . '">Edit</a> | <a href="delete_menu.php?id=' . $row['id'] . '">Delete</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="5">No menu available</td></tr>';
            }
            ?>
        </table>

        <h2>Riwayat Pesanan</h2>
        <table>
            <tr>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Action</th>
            </tr>
            <?php
            $sql = "SELECT orders.id, orders.name, orders.address, GROUP_CONCAT(menu.name SEPARATOR ', ') AS menu_names, orders.quantity, orders.total_price FROM orders INNER JOIN menu ON orders.menu_id = menu.id GROUP BY orders.id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '<td>' . $row['address'] . '</td>';
                    echo '<td>' . $row['menu_names'] . '</td>';
                    echo '<td>' . $row['quantity'] . '</td>';
                    echo '<td>' . $row['total_price'] . '</td>';
                    echo '<td><a href="edit_order.php?id=' . $row['id'] . '">Edit</a> | <a href="delete_order.php?id=' . $row['id'] . '">Delete</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No order history available</td></tr>';
            }
            ?>
        </table>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
