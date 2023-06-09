<?php require_once('../config.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <style>
        /* CSS Styles */
        body {
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            max-width: 400px;
            margin: 0 auto;
            padding: 50px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="text"]:focus,
        input[type="password"]:focus,
        input[type="email"]:focus {
            outline: none;
            border-color: #0066cc;
        }

        input[type="submit"] {
            background-color: #0066cc;
            color: #fff;
            padding: 12px;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #0052a2;
        }

        p {
            text-align: center;
            margin-top: 10px;
            color: #666;
        }

        a {
            color: #0066cc;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="submit" value="Register">
        </form>
        <p>Apakah sudah punya akun? <a href="login.php">Login</a></p>
    </div>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    $config = new Config(); 
    $connection = $config->getConnection(); 

    $stmt = $connection->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $email);
    $result = $stmt->execute();

    if ($result) {
        $stmt->close();
        header('Location: login.php');
        exit;
    } else {
        echo '<script>alert("Registration failed")</script>';
    }

    $stmt->close();
}
?>
