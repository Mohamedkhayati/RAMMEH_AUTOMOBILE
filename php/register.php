<?php
session_start();
include('database.php');  // Include your database connection

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = trim($_POST['email']);
    

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        try {
            $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                $error = "Username already exists. Please choose another one.";
            } else {
                $hashed_password = md5($password);
                $sql = "INSERT INTO users (username, password, email, role) VALUES (:username, :password, :email, 'user')";
                $stmt = $conn->prepare($sql);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':email', $email);
                
                if ($stmt->execute()) {
                    header("Location: login.php");
                    exit();
                } else {
                    $error = "Error creating account. Please try again.";
                }
            }
        } catch (PDOException $e) {
            $error = "Database error: " . $e->getMessage();
        }
    }
}
?>
<?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
