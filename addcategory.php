<?php
// Include your database connection script
$servername = "localhost";
$username = "root";
$password = "";
$databasename = "auctioncys";

// Establish a connection to the database
try {
    $mov = new PDO("mysql:host=$servername;dbname=$databasename", $username, $password);
    $mov->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    die(); // Stop execution if connection fails
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve and sanitize input
    $categoryName = filter_input(INPUT_POST, 'categoryName', FILTER_SANITIZE_STRING);

    // Check if category name is provided
    if (!empty($categoryName)) {
        // Insert data into database
        $sql = "INSERT INTO addcategory (category_name) 
                VALUES (:category_name)";

        $stmt = $mov->prepare($sql);
        $stmt->bindParam(':category_name', $categoryName);

        try {
            if ($stmt->execute()) {
                echo "Category created successfully";
            } else {
                echo "Error: Unable to execute query";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    } else {
        echo "Category name is required";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category - FotHeBay</title>
    <link rel="stylesheet" href="style_auction.css"> <!-- Link to your external CSS file -->
    <!-- Ensure the correct HTML syntax for linking external CSS -->
</head>
<body>
    <div class="container">
        <h2>Add New Category</h2>
        <form action="addCategory.php" method="POST"> <!-- Ensure the correct action attribute -->
            <div class="form-group">
                
                <label for="categoryName">Category Name</label>
                <input type="text" id="categoryName" name="categoryName" required>
            </div>
            <div class="form-group">
                <button type="submit">Add Category</button>
            </div>
        </form>
    </div>
</body>
</html>
