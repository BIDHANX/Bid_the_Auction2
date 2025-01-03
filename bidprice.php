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
$currentHighestBid = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM addauction WHERE id = :id";
    $stmt = $mov->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch the current highest bid
    $sql_bid = "SELECT MAX(bid_amount) as highest_bid FROM bids WHERE auction_id = :id";
    $stmt_bid = $mov->prepare($sql_bid);
    $stmt_bid->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_bid->execute();
    $currentHighestBid = $stmt_bid->fetch(PDO::FETCH_ASSOC)['highest_bid'];
    $currentHighestBid = $currentHighestBid ? $currentHighestBid : $item['estimated_price']; // If no bids, show the estimated price as the current bid
}

// Handle bid submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auctionId = $_POST['auction_id'];
    $bidAmount = $_POST['bid_amount'];

    // Validate the bid
    if ($bidAmount > $currentHighestBid) {
        $sql_bid_insert = "INSERT INTO bids (auction_id, bid_amount) VALUES (:auction_id, :bid_amount)";
        $stmt_bid_insert = $mov->prepare($sql_bid_insert);
        $stmt_bid_insert->bindParam(':auction_id', $auctionId, PDO::PARAM_INT);
        $stmt_bid_insert->bindParam(':bid_amount', $bidAmount, PDO::PARAM_STR);
        $stmt_bid_insert->execute();
        $currentHighestBid = $bidAmount; // Update the current highest bid
    } else {
        $error_message = "Your bid must be higher than the current highest bid.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Bid - FotHeBay</title>
    <link rel="stylesheet" href="style_auction.css"> <!-- Link to your external CSS file -->
</head>
<body>

    <?php require('navbar.php'); ?>

    <div class="container">
        <h2>Place Bid</h2>
        <?php if ($item): ?>
            <p><strong>Artist Name:</strong> <?php echo htmlspecialchars($item['artist_name']); ?></p>
            <p><strong>Lot Number:</strong> <?php echo htmlspecialchars($item['lot_number']); ?></p>
            <p><strong>Current Highest Bid:</strong> <?php echo number_format($currentHighestBid, 2); ?></p>
            <form action="bidprice.php?id=<?php echo htmlspecialchars($item['id']); ?>" method="POST">
                <input type="hidden" name="auction_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                <label for="bid_amount">Your Bid:</label>
                <input type="number" step="0.01" id="bid_amount" name="bid_amount" required>
                <button type="submit">Place Bid</button>
            </form>
            <?php if (isset($error_message)): ?>
                <p style="color:red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
        <?php else: ?>
            <p>Item not found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
