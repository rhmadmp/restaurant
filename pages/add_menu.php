<?php include('../config.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Menu</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <?php include('../includes/header.php'); ?>

    <div class="container">
    <h1>Add New Menu</h1>
    <form action="process_add_menu.php" method="POST" enctype="multipart/form-data">
        <label for="name">Menu Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="description">Description:</label>
        <textarea id="description" name="description" required></textarea>
        
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" required>
        
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" required>
        
        <input type="submit" value="Add Menu">
    </form>
</div>


    <?php include('../includes/footer.php'); ?>
</body>
</html>
