<?php
include('../config.php');

$config = new Config();
$conn = $config->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id = $_GET['id'];

    try {
        // Hapus menu dari database
        $delete_sql = "DELETE FROM menu WHERE id='$id'";
        $delete_result = mysqli_query($conn, $delete_sql);

        if ($delete_result) {
            header('Location: admin.php');
            exit;
        } else {
            echo 'Failed to delete menu.';
        }
    } catch (mysqli_sql_exception $e) {
        echo 'Menu cannot be deleted because there are associated orders.';
    }
}
?>
