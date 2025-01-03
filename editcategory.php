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

$auction = []; // Initialize $auction array

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch category details
    $sql = "SELECT * FROM addcategory WHERE id = :id";
    $stmt = $mov->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        if ($stmt->execute()) {
            $auction = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$auction) {
                echo "Category not found";
            }
        } else {
            echo "Error fetching category";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $categoryName = $_POST['categoryName'];

    // Update data in the database
    $sql = "UPDATE addcategory 
            SET category_name = :category_name
            WHERE id = :id";

    $stmt = $mov->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':category_name', $categoryName, PDO::PARAM_STR);

    try {
        if ($stmt->execute()) {
            echo "Category updated successfully";
        } else {
            echo "Error updating category";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Category Item - FotHeBay</title>
    <link rel="stylesheet" href="style_auction.css"> <!-- Link to your external CSS file -->
</head>
<body>
    <div class="edit-category-container"> <!-- Updated class here -->
        <h2>Edit Category Item</h2>
        <form action="editcategory.php?id=<?php echo isset($auction['id']) ? htmlspecialchars($auction['id']) : ''; ?>" method="POST">
            <input type="hidden" name="id" value="<?php echo isset($auction['id']) ? htmlspecialchars($auction['id']) : ''; ?>">
            <div class="form-group">
                <label for="categoryName">Category Name</label>
                <input type="text" id="categoryName" name="categoryName" value="<?php echo isset($auction['category_name']) ? htmlspecialchars($auction['category_name']) : ''; ?>" required>
            </div> 
            <div class="form-group">
                <button type="submit">Update Category Item</button>
            </div>
        </form>
    </div>
</body>
</html>
