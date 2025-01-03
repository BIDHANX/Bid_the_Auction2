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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            $imagePath = null;
        }
    } else {
        $imagePath = null;
    }

    // Insert data into database
    $sql = "INSERT INTO addauction (lot_number, artist_name, year_produced, subject_classification, description, auction_date, estimated_price, category_name, drawing_medium, framed, dimensions_height, dimensions_length, image_path) 
            VALUES (:lot_number, :artist_name, :year_produced, :subject_classification, :description, :auction_date, :estimated_price, :category_name, :drawing_medium, :framed, :dimensions_height, :dimensions_length, :image_path)";

    $stmt = $mov->prepare($sql);
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
        echo "New record created successfully";
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
    <title>Add Auction Item - FotHeBay</title>
    <link rel="stylesheet" href="style_auction.css"> <!-- Link to your external CSS file -->
</head>
<body>
    <div class="container">
        <h2>Add Auction Item</h2>
        <form action="addAuction.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="lotNumber">Lot Number (8 digits)</label>
                <input type="text" id="lotNumber" name="lotNumber" pattern="\d{8}" required>
            </div>
            <div class="form-group">
                <label for="artistName">Artist Name</label>
                <input type="text" id="artistName" name="artistName" required>
            </div>
            <div class="form-group">
                <label for="yearProduced">Year Produced</label>
                <input type="text" id="yearProduced" name="yearProduced" pattern="\d{4}" required>
            </div>
            <div class="form-group">
                <label for="subjectClassification">Subject Classification</label>
                <select id="subjectClassification" name="subjectClassification" required>
                    <option value="landscape">Landscape</option>
                    <option value="seascape">Seascape</option>
                    <option value="portrait">Portrait</option>
                    <option value="figure">Figure</option>
                    <option value="still life">Still Life</option>
                    <option value="nude">Nude</option>
                    <option value="animal">Animal</option>
                    <option value="abstract">Abstract</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label for="auctionDate">Auction Date</label>
                <input type="date" id="auctionDate" name="auctionDate">
            </div>
            <div class="form-group">
                <label for="estimatedPrice">Estimated Price</label>
                <input type="number" id="estimatedPrice" name="estimatedPrice" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="categoryName">Category Name</label>
                <select id="categoryName" name="categoryName" required>
                    <option value="drawings">Drawings</option>
                    <option value="paintings">Paintings</option>
                    <option value="photographic images">Photographic Images</option>
                    <option value="sculptures">Sculptures</option>
                    <option value="carvings">Carvings</option>
                </select>
            </div>
            <div class="form-group">
                <label for="drawingMedium">Drawing Medium</label>
                <input type="text" id="drawingMedium" name="drawingMedium">
            </div>
            <div class="form-group">
                <label for="framed">Framed?</label>
                <input type="checkbox" id="framed" name="framed" value="yes">
                <label for="framed">Yes</label>
            </div>
            <div class="form-group">
                <label for="dimensionsHeight">Dimensions (Height in cm)</label>
                <input type="number" id="dimensionsHeight" name="dimensionsHeight" step="0.01">
            </div>
            <div class="form-group">
                <label for="dimensionsLength">Dimensions (Length in cm)</label>
                <input type="number" id="dimensionsLength" name="dimensionsLength" step="0.01">
            </div>
            <div class="form-group">
                <label for="itemImage">Upload Image</label>
                <input type="file" id="itemImage" name="itemImage" accept="image/*">
            </div>
            <div class="form-group">
                <button type="submit">Add Item</button>
            </div>
        </form>
    </div>
</body>
</html>
