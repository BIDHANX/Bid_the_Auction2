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

    // Delete the auction item
    $sql = "DELETE FROM addauction WHERE id = :id";
    $stmt = $mov->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
