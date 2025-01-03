<?php
require('navbar.php');
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    // Redirect to login if not authenticated as admin
    header("Location: index.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - FotHeBay</title>
    <link rel="stylesheet" href="style_auction.css"> <!-- Link to your external CSS file -->
</head>
<body>
    <div class="admin-dashboard-container">
        <div class="admin-section">
            <h1>Auction</h1>
            <p><a href="addAuction.php" class="admin-dashboard-link" >ADD AUCTION</a></p> 
            <p><a href="manageauction.php" class="admin-dashboard-link">MANAGE AUCTION</a></p> 
        </div>

        <div class="admin-section">
            <h1>Category</h1>
            <p><a href="addcategory.php" class="admin-dashboard-link">ADD CATEGORY</a></p> 
            <p><a href="managecategory.php" class="admin-dashboard-link">MANAGE CATEGORY</a></p> 
        </div>

        <!-- <div class="admin-section">
            <h1>Catalog</h1>
            <p><a href="addSeller.php" class="admin-dashboard-link">ADD Seller</a></p> 
            <p><a href="manageSeller.php" class="admin-dashboard-link">Manage Seller</a></p> 
        </div> -->
    </div>
</body>
</html>
