<?php
include 'db.php';

$artist_name = $_GET['artist_name'];
$sql = "SELECT * FROM items WHERE artist_name LIKE '%$artist_name%'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-left">
            <a href="index.php">Home</a>
            <a href="add_item.php">Add Item</a>
            <a href="display_items.php">Display Items</a>
        </div>
        <div class="navbar-middle">
            <form action="search_results.php" method="get" class="search-form">
                <input type="text" name="artist_name" placeholder="Search by Artist Name">
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="navbar-right">
            <a href="login.php" class="login-btn">Login</a>
        </div>
    </nav>

    <div class="content">
        <h1>Search Results for "<?php echo $artist_name; ?>"</h1>
        <table border="1">
            <tr>
                <th>Lot Number</th>
                <th>Artist Name</th>
                <th>Year Produced</th>
                <th>Subject Classification</th>
                <th>Description</th>
                <th>Estimated Price</th>
                <th>Category</th>
                <th>Dimensions</th>
                <th>Weight</th>
                <th>Additional Details</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["lot_number"] . "</td>";
                    echo "<td>" . $row["artist_name"] . "</td>";
                    echo "<td>" . $row["year_produced"] . "</td>";
                    echo "<td>" . $row["subject_classification"] . "</td>";
                    echo "<td>" . $row["description"] . "</td>";
                    echo "<td>" . $row["estimated_price"] . "</td>";
                    echo "<td>" . $row["category"] . "</td>";
                    echo "<td>" . $row["dimensions"] . "</td>";
                    echo "<td>" . $row["weight"] . "</td>";
                    echo "<td>";
                    switch ($row["category"]) {
                        case 'drawing':
                            echo "Drawing Medium: " . $row["drawing_medium"];
                            break;
                        case 'painting':
                            echo "Painting Medium: " . $row["painting_medium"];
                            break;
                        case 'photographic_image':
                            echo "Photo Type: " . $row["photo_type"];
                            break;
                        case 'sculpture':
                            echo "Sculpture Material: " . $row["sculpture_material"];
                            break;
                        case 'carving':
                            echo "Carving Material: " . $row["carving_material"];
                            break;
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No items found</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>

<?php
$conn->close();
?>
