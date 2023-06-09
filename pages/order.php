<?php
require_once('../config.php');

$config = new Config();
$conn = $config->getConnection();

// Cek apakah tombol "Place Order" diklik
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $menuIds = $_POST['menu'];
    $quantities = $_POST['quantity'];

    // Validasi input jika diperlukan

    // Simpan pesanan ke dalam database
    $success = true;
    $orderIds = array();
    foreach ($menuIds as $index => $menuId) {
        $quantity = $quantities[$index];

        // Mendapatkan harga menu dari database
        $sql = "SELECT price FROM menu WHERE id='$menuId'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $price = $row['price'];

        $totalPrice = $price * $quantity;

        $sql = "INSERT INTO orders (name, address, menu_id, quantity, total_price) VALUES ('$name', '$address', '$menuId', '$quantity', '$totalPrice')";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            $success = false;
            break;
        }

        $orderIds[] = mysqli_insert_id($conn);
    }

    if ($success) {
        echo 'Pesanan Berhasil dibuat. Order IDs: ' . implode(', ', $orderIds);
    } else {
        echo 'Pesanan gagal dibuat.';
    }
}

// Proses untuk menghapus pesanan
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $orderId = $_GET['id'];

    $sql = "DELETE FROM orders WHERE id='$orderId'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo 'Pesanan berhasil dihapus.';
    } else {
        echo 'Pesanan gagal dihapus.';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container">
        <h1>Order Menu</h1>
        <form action="order.php" method="POST" id="orderForm">
            <label for="name">Nama:</label>
            <input type="text" id="name" name="name" required>
            
            <label for="address">Alamat:</label>
            <textarea id="address" name="address" required></textarea>
            
            <div id="menuItems">
                <div class="menu-item">
                    <label>Menu:</label>
                    <select name="menu[]" required>
                        <?php
                        // Mendapatkan daftar menu dari database
                        $sql = "SELECT * FROM menu";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                            }
                        } else {
                            echo '<option value="">No menu available</option>';
                        }
                        ?>
                    </select>

                    <label>Jumlah:</label>
                    <input type="number" name="quantity[]" required>
                </div>
            </div>
            
            <button type="button" id="addMenuItem">Tambah Item Menu</button>
            
            <input type="submit" name="place_order" value="Pesan">
        </form>

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
                    echo '<td><a href="edit_order.php?id=' . $row['id'] . '">Edit</a> | <a href="order.php?action=delete&id=' . $row['id'] . '">Delete</a></td>';
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="6">No orders available</td></tr>';
            }
            ?>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            var menuCount = 2; // Start with the second menu item

            $('#addMenuItem').click(function() {
                var newMenuItem = `
                    <div class="menu-item">
                        <label>Menu:</label>
                        <select name="menu[]" required>
                            <?php
                            // Mendapatkan daftar menu dari database
                            $sql = "SELECT * FROM menu";
                            $result = mysqli_query($conn, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                }
                            } else {
                                echo '<option value="">No menu available</option>';
                            }
                            ?>
                        </select>

                        <label>Quantity:</label>
                        <input type="number" name="quantity[]" required>
                    </div>
                `;
                $('#menuItems').append(newMenuItem);

                menuCount++;
            });
        });
    </script>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
