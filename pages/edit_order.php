<?php
include('../config.php');

$config = new Config();
$conn = $config->getConnection();

$order_id = $_GET['id'];

// Mendapatkan data pesanan berdasarkan ID
$sql = "SELECT * FROM orders WHERE id='$order_id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $menu_id = $_POST['menu_id'];
    $quantity = $_POST['quantity'];

    // Mendapatkan harga menu dari database
    $menu_sql = "SELECT price FROM menu WHERE id='$menu_id'";
    $menu_result = mysqli_query($conn, $menu_sql);
    $menu_row = mysqli_fetch_assoc($menu_result);
    $price = $menu_row['price'];

    // Menghitung total_price baru
    $totalPrice = $price * $quantity;

    $sql = "UPDATE orders SET name='$name', address='$address', menu_id='$menu_id', quantity='$quantity', total_price='$totalPrice' WHERE id='$order_id'";
    if (mysqli_query($conn, $sql)) {
        header('Location: order.php');
        exit;
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Order</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container">
        <h1>Edit Order</h1>
        <form method="POST" action="">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required>

            <label for="address">Address:</label>
            <textarea id="address" name="address" required><?php echo $row['address']; ?></textarea>

            <label for="menu_id">Menu:</label>
            <select name="menu_id" id="menu_id">
                <?php
                // Mendapatkan daftar menu
                $menu_sql = "SELECT * FROM menu";
                $menu_result = mysqli_query($conn, $menu_sql);

                if (mysqli_num_rows($menu_result) > 0) {
                    while ($menu_row = mysqli_fetch_assoc($menu_result)) {
                        $selected = ($row['menu_id'] == $menu_row['id']) ? 'selected' : '';
                        echo '<option value="' . $menu_row['id'] . '" ' . $selected . '>' . $menu_row['name'] . '</option>';
                    }
                }
                ?>
            </select>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" value="<?php echo $row['quantity']; ?>" required>

            <input type="submit" name="submit" value="Update">
        </form>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
