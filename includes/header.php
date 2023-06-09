<!DOCTYPE html>
<html>
<head>
    <title>Restaurant</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
</head>
<body>
    <header>
        <h1>Restaurant</h1>
        <nav>
            <ul>
                <?php
                if (isset($_SESSION['username'])) {
                    echo '<li><a href="menu.php">Menu</a></li>';
                    echo '<li><a href="admin.php">Admin</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                } else {
                    echo '<li><a href="login.php">Login</a></li>';
                    echo '<li><a href="register.php">Register</a></li>';
                    echo '<li><a href="menu.php">Menu</a></li>';
                    echo '<li><a href="order.php">Pesanan</a></li>';
                    echo '<li><a href="admin.php">Admin</a></li>';
                    echo '<li><a href="logout.php">Logout</a></li>';
                }
                ?>
            </ul>
        </nav>
    </header>
</body>
</html>
