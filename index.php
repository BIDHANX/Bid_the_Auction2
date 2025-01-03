<?php require('navbar.php'); ?>


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

// Fetch all items from the database along with their current highest bid
$sql = "
    SELECT a.*, 
           COALESCE(b.highest_bid, a.estimated_price) AS current_highest_bid
    FROM addauction a
    LEFT JOIN (
        SELECT auction_id, MAX(bid_amount) AS highest_bid
        FROM bids
        GROUP BY auction_id
    ) b ON a.id = b.auction_id
";
$stmt = $mov->prepare($sql);
$stmt->execute();
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="auction-container">
    <h2>Available Auction </h2>
    <div class="items">
        <?php foreach ($items as $item): ?>
            <div class="item">
                <?php if ($item['image_path']): ?>
                    <img src="<?php echo htmlspecialchars($item['image_path']); ?>" alt="Item Image">
                <?php endif; ?>
                <p><strong>Lot Number:</strong> <?php echo htmlspecialchars($item['lot_number']); ?></p>
                <p><strong>Current Highest Bid:</strong> <?php echo number_format($item['current_highest_bid'], 2); ?></p>
                <p><strong>Subject Classification:</strong> <?php echo htmlspecialchars($item['subject_classification']); ?></p>
                <div class="buttons">
                    <form action="item.php" method="GET" style="margin: 0;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                        <button type="submit">View More</button>
                    </form>
                    <form action="bidprice.php" method="GET" style="margin: 0;">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($item['id']); ?>">
                        <button type="submit">Bid</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
