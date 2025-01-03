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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch auction item details
    $sql = "SELECT * FROM addauction WHERE id = :id";
    $stmt = $mov->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $auction = $stmt->fetch(PDO::FETCH_ASSOC);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $lotNumber = $_POST['lotNumber'];
    $artistName = $_POST['artistName'];
    $yearProduced = $_POST['yearProduced'];
    $subjectClassification = $_POST['subjectClassification'];
    $description = $_POST['description'];
    $auctionDate = $_POST['auctionDate'];
    $estimatedPrice = $_POST['estimatedPrice'];
    $categoryName = $_POST['categoryName'];
    $drawingMedium = $_POST['drawingMedium'];
    $framed = isset($_POST['framed']) ? 1 : 0;
    $dimensionsHeight = $_POST['dimensionsHeight'];
    $dimensionsLength = $_POST['dimensionsLength'];

    // Handle file upload
    if (isset($_FILES['itemImage']) && $_FILES['itemImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['itemImage']['tmp_name'];
        $fileName = $_FILES['itemImage']['name'];
        $fileSize = $_FILES['itemImage']['size'];
        $fileType = $_FILES['itemImage']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Sanitize file name
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

        // Directory where the file will be saved
        $uploadFileDir = './uploaded_files/';
        $dest_path = $uploadFileDir . $newFileName;

        // Check if the directory exists, if not create it
        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0777, true);
        }

        // Move the file to the desired directory
        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $imagePath = $dest_path;
        } else {
            $imagePath = $auction['image_path'];
        }
    } else {
        $imagePath = $auction['image_path'];
    }

    // Update data in the database
    $sql = "UPDATE addauction 
            SET lot_number = :lot_number, artist_name = :artist_name, year_produced = :year_produced, subject_classification = :subject_classification, description = :description, auction_date = :auction_date, estimated_price = :estimated_price, category_name = :category_name, drawing_medium = :drawing_medium, framed = :framed, dimensions_height = :dimensions_height, dimensions_length = :dimensions_length, image_path = :image_path 
            WHERE id = :id";

    $stmt = $mov->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':lot_number', $lotNumber);
    $stmt->bindParam(':artist_name', $artistName);
    $stmt->bindParam(':year_produced', $yearProduced);
    $stmt->bindParam(':subject_classification', $subjectClassification);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':auction_date', $auctionDate);
    $stmt->bindParam(':estimated_price', $estimatedPrice);
    $stmt->bindParam(':category_name', $categoryName);
    $stmt->bindParam(':drawing_medium', $drawingMedium);
    $stmt->bindParam(':framed', $framed, PDO::PARAM_INT);
    $stmt->bindParam(':dimensions_height', $dimensionsHeight);
    $stmt->bindParam(':dimensions_length', $dimensionsLength);
    $stmt->bindParam(':image_path', $imagePath);

    if ($stmt->execute()) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Auction Item - FotHeBay</title>
    <link rel="stylesheet" href="style_auction.css"> <!-- Link to your external CSS file -->
    
</head>
<body>
    <div class="custom-container">
        <h2>Edit Auction Item</h2>
        <form action="editAuction.php?id=<?php echo $auction['id']; ?>" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $auction['id']; ?>">
            <div class="custom-form-group">
                <label for="lotNumber">Lot Number (8 digits)</label>
                <input type="text" id="lotNumber" name="lotNumber" value="<?php echo htmlspecialchars($auction['lot_number']); ?>" required>
            </div>
            <div class="custom-form-group">
                <label for="artistName">Artist Name</label>
                <input type="text" id="artistName" name="artistName" value="<?php echo htmlspecialchars($auction['artist_name']); ?>" required>
            </div>
            <div class="custom-form-group">
                <label for="yearProduced">Year Produced</label>
                <input type="number" id="yearProduced" name="yearProduced" value="<?php echo htmlspecialchars($auction['year_produced']); ?>" required>
            </div>
            <div class="custom-form-group">
                <label for="subjectClassification">Subject Classification</label>
                <input type="text" id="subjectClassification" name="subjectClassification" value="<?php echo htmlspecialchars($auction['subject_classification']); ?>" required>
            </div>
            <div class="custom-form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($auction['description']); ?></textarea>
            </div>
            <div class="custom-form-group">
                <label for="auctionDate">Auction Date</label>
                <input type="date" id="auctionDate" name="auctionDate" value="<?php echo htmlspecialchars($auction['auction_date']); ?>" required>
            </div>
            <div class="custom-form-group">
                <label for="estimatedPrice">Estimated Price</label>
                <input type="number" id="estimatedPrice" name="estimatedPrice" value="<?php echo htmlspecialchars($auction['estimated_price']); ?>" required>
            </div>
            <div class="custom-form-group">
                <label for="categoryName">Category Name</label>
                <input type="text" id="categoryName" name="categoryName" value="<?php echo htmlspecialchars($auction['category_name']); ?>" required>
            </div>
            <div class="custom-form-group">
                <label for="drawingMedium">Drawing Medium</label>
                <input type="text" id="drawingMedium" name="drawingMedium" value="<?php echo htmlspecialchars($auction['drawing_medium']); ?>" required>
            </div>
            <div class="custom-form-group">
                <label for="framed">Framed</label>
                <input type="checkbox" id="framed" name="framed" <?php echo $auction['framed'] ? 'checked' : ''; ?>>
            </div>
            <div class="custom-form-group">
                <label for="dimensionsHeight">Dimensions Height (cm)</label>
                <input type="number" id="dimensionsHeight" name="dimensionsHeight" value="<?php echo htmlspecialchars($auction['dimensions_height']); ?>" required>
            </div>
            <div class="custom-form-group">
                <label for="dimensionsLength">Dimensions Length (cm)</label>
                <input type="number" id="dimensionsLength" name="dimensionsLength" value="<?php echo htmlspecialchars($auction['dimensions_length']); ?>" required>
            </div>
            <div class="custom-form-group">
                <label for="itemImage">Item Image</label>
                <input type="file" id="itemImage" name="itemImage">
                <img src="<?php echo htmlspecialchars($auction['image_path']); ?>" alt="Image" width="50">
            </div>
            <div class="custom-form-group">
                <button type="submit">Update Auction Item</button>
            </div>
        </form>
    </div>
</body>
</html>

