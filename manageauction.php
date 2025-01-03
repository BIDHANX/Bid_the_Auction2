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
}

// Fetch auction items
$sql = "SELECT * FROM addauction";
$stmt = $mov->prepare($sql);
$stmt->execute();
$auctions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Auction Items - FotHeBay</title>
    <link rel="stylesheet" href="style_auction.css"> <!-- Link to your external CSS file -->
</head>
<body>
    <div class="container manage-auction-container">
        <h2>Manage Auction Items</h2>
        <table class="manage-auction-table">
            <thead>
                <tr>
                    <th>Lot Number</th>
                    <th>Artist Name</th>
                    <th>Year Produced</th>
                    <th>Subject Classification</th>
                    <th>Description</th>
                    <th>Auction Date</th>
                    <th>Estimated Price</th>
                    <th>Category Name</th>
                    <th>Drawing Medium</th>
                    <th>Framed</th>
                    <th>Dimensions</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($auctions as $auction): ?>
                <tr>
                    <td><?php echo htmlspecialchars($auction['lot_number']); ?></td>
                    <td><?php echo htmlspecialchars($auction['artist_name']); ?></td>
                    <td><?php echo htmlspecialchars($auction['year_produced']); ?></td>
                    <td><?php echo htmlspecialchars($auction['subject_classification']); ?></td>
                    <td><?php echo htmlspecialchars($auction['description']); ?></td>
                    <td><?php echo htmlspecialchars($auction['auction_date']); ?></td>
                    <td><?php echo htmlspecialchars($auction['estimated_price']); ?></td>
                    <td><?php echo htmlspecialchars($auction['category_name']); ?></td>
                    <td><?php echo htmlspecialchars($auction['drawing_medium']); ?></td>
                    <td><?php echo $auction['framed'] ? 'Yes' : 'No'; ?></td>
                    <td><?php echo htmlspecialchars($auction['dimensions_height'] . ' x ' . $auction['dimensions_length']); ?></td>
                    <td><img src="<?php echo htmlspecialchars($auction['image_path']); ?>" alt="Image"></td>
                    <td class="actions">
                        <a href="editauction.php?id=<?php echo $auction['id']; ?>">Edit</a>
                        <a href="deleteauction.php?id=<?php echo $auction['id']; ?>">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>

