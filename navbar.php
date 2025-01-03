<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FotHeBay</title>
    <link rel="stylesheet" href="style_auction.css"> <!-- Link to your external CSS file -->
</head>
<body>
    <nav class="custom-navbar">
        <div class="custom-container">
            <span class="custom-navbar-brand">FotHeBay</span>
            <ul class="custom-nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="information.php">About</a></li>
                <li><a href="#">Contact</a></li>
                <li><a href="adminpage.php">Admin</a></li>
            </ul>
            <form class="custom-search-form">
                <input type="text" placeholder="Search..." />
                <button type="submit">Search</button>
            </form>
            <div class="custom-user-actions">
                <?php
                session_start();
                if (isset($_SESSION['user_id'])) {
                    // User is logged in
                    echo '<a href="logout.php">Logout</a>';
                } else {
                    // User is not logged in
                    echo '<a href="login.php">Login</a>';
                }
                ?>
            </div>
        </div>
    </nav>
</body>
</html>
