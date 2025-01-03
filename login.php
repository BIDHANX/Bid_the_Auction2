<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FotHeBay</title>
    <link rel="stylesheet" href="style_auction.css"> <!-- Link to your external CSS file -->
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2>Login</h2>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <div class="login-form-group">
                    <label for="loginEmail">Email</label>
                    <input type="email" id="loginEmail" name="loginEmail" required>
                </div>
                <div class="login-form-group">
                    <label for="loginPassword">Password</label>
                    <input type="password" id="loginPassword" name="loginPassword" required>
                </div>
                <div class="login-form-group">
                    <label>Select Your Role:</label>
                    <div class="login-role-options">
                        <div>
                            <input type="radio" id="userTypeUser" name="userType" value="user" checked>
                            <label for="userTypeUser">User</label>
                        </div>
                        <div>
                            <input type="radio" id="userTypeSeller" name="userType" value="seller">
                            <label for="userTypeSeller">Seller</label>
                        </div>
                        <div>
                            <input type="radio" id="userTypeAdmin" name="userType" value="admin">
                            <label for="userTypeAdmin">Admin</label>
                        </div>
                    </div>
                </div>
                <div class="login-form-group">
                    <button type="submit" name="submit">Login</button>
                </div>
            </form>
        </div>

        <div class="center-content">
            <p>New user? <a href="register.php">Register here</a></p>
        </div>
    </div>

    <?php
    // Database connection parameters
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

    // Check if admin credentials exist, if not, insert them
    $admin_email = 'sonam@gmail.com';
    $admin_password_hash = password_hash('88888888', PASSWORD_DEFAULT);

    $stmt_check_admin = $mov->prepare('SELECT * FROM admin WHERE email = :email');
    $stmt_check_admin->bindParam(':email', $admin_email);
    $stmt_check_admin->execute();
    $admin_exists = $stmt_check_admin->fetch(PDO::FETCH_ASSOC);

    if (!$admin_exists) {
        $stmt_insert_admin = $mov->prepare('INSERT INTO admin (email, password) VALUES (:email, :password)');
        $stmt_insert_admin->bindParam(':email', $admin_email);
        $stmt_insert_admin->bindParam(':password', $admin_password_hash);
        $stmt_insert_admin->execute();
    }

    // Process login form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        $email = $_POST['loginEmail'];
        $password = $_POST['loginPassword'];
        $role = $_POST['userType'];

        if ($role === 'admin') {
            // Admin login logic
            $stmt = $mov->prepare('SELECT * FROM admin WHERE email = :email');
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $admin = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password'])) {
                session_start();
                $_SESSION['user_id'] = $admin['id'];
                $_SESSION['user_role'] = 'admin';
                header("Location: adminpage.php");
                exit();
            } else {
                echo "Incorrect email or password.";
            }
        } else {
            // User or seller login logic
            $stmt = $mov->prepare('SELECT * FROM register WHERE email = :email');
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_role'] = $role;
                if ($role === 'seller') {
                    header("Location: sellerpage.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                echo "Incorrect email or password.";
            }
        }
    }
    ?>
</body>
</html>
