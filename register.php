<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FotHeBay</title>
    <link rel="stylesheet" href="style_auction.css"> <!-- Link to your external CSS file -->
   
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <div class="custom-form-container">
            <form action="register.php" method="post">
                <label>Name:</label>
                <input type="text" name="name" required>
                <br>
                <label>Address:</label>
                <input type="text" name="address" required>
                <br>
                <label>Phone Number:</label>
                <input type="text" name="number" required>
                <br>
                <label>Email Address:</label>
                <input type="email" name="email" required>
                <br>
                <label>Password:</label>
                <input type="password" name="password" required>
                <br>
                <label>Confirm Password:</label>
                <input type="password" name="confirm_password" required>
                <br>
                <label>Select Your Role:</label>
                <select name="role" required>
                    <option value="user">User</option>
                    <option value="seller">Seller</option>
                    <option value="admin">Admin</option>
                </select>
                <br>
                <input type="submit" value="Submit" name="submit">
            </form>
        </div>
        <p>Already registered? <a href="login.php">Login here</a></p>
    </div>
</body>
</html>

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

if (isset($_POST['submit'])) {
    // Sanitize and validate inputs
    $name = htmlspecialchars($_POST['name']);
    $address = htmlspecialchars($_POST['address']);
    $number = htmlspecialchars($_POST['number']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = $_POST['role'];

    // Validate passwords
    if ($password !== $confirm_password) {
        echo "Passwords do not match. Please try again.";
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Prepare SQL statement to insert data
        $stmt = $mov->prepare('INSERT INTO register (name, address, number, email, password, role) 
                               VALUES (:name, :address, :number, :email, :password, :role)');
        
        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':number', $number);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':role', $role);

        // Execute the statement
        $stmt->execute();

        // Redirect after successful registration
        header("Location: login.php");
        exit();
    } catch(PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
