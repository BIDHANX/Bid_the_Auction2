<?php
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
}

// Fetch the item details from the database
$item = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM addauction WHERE id = :id";
    $stmt = $mov->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Item Details - FotHeBay</title>
    <link rel="stylesheet" href="style_auction.css"> <!-- Link to your item-details.css file -->
</head>
<body>

    <?php require('navbar.php'); ?>


    <div class="container item-details-container">
        <h2>Item Details</h2>
        <?php if ($item): ?>
            <div class="item">
                <h3><?php echo htmlspecialchars($item['artist_name']); ?></h3>
                <p><strong>Lot Number:</strong> <?php echo htmlspecialchars($item['lot_number']); ?></p>
                <p><strong>Year Produced:</strong> <?php echo htmlspecialchars($item['year_produced']); ?></p>
                <p><strong>Subject Classification:</strong> <?php echo htmlspecialchars($item['subject_classification']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($item['description']); ?></p>
                <p><strong>Auction Date:</strong> <?php echo htmlspecialchars($item['auction_date']); ?></p>
                <p><strong>Starting Price:</strong> <?php echo htmlspecialchars($item['estimated_price']); ?></p>
                <p><strong>Category Name:</strong> <?php echo htmlspecialchars($item['category_name']); ?></p>
                <p><strong>Drawing Medium:</strong> <?php echo htmlspecialchars($item['drawing_medium']); ?></p>
                <p><strong>Framed:</strong> <?php echo $item['framed'] ? 'Yes' : 'No'; ?></p>
                <p><strong>Dimensions (Height x Length in cm):</strong> <?php echo htmlspecialchars($item['dimensions_height']) . ' x ' . htmlspecialchars($item['dimensions_length']); ?></p>
                <?php if ($item['image_path']): ?>
                    <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="Item Image">
                <?php endif; ?>
            </div>
        <?php else: ?>
            <p>Item not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
