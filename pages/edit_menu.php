<?php
include('../config.php');

$config = new Config();
$conn = $config->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $sql = "UPDATE menu SET name='$name', description='$description', price='$price' WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('Location: admin.php');
        exit;
    } else {
        echo 'Failed to update menu.';
    }
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM menu WHERE id='$id'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $description = $row['description'];
        $price = $row['price'];
    } else {
        echo 'Menu not found.';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Menu</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container">
        <h1>Edit Menu</h1>
        <form action="" method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label for="name">Menu Name:</label>
            <input type="text" id="name" name="name" value="<?php echo $name; ?>" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?php echo $description; ?></textarea>

            <label for="price">Price:</label>
            <input type="number" id="price" name="price" value="<?php echo $price; ?>" required>

            <input type="submit" value="Update Menu">
        </form>
    </div>

    <?php include('../includes/footer.php'); ?>
</body>
</html>
