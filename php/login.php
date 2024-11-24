<?php
session_start();


function password_verify($password, $hash) {
    if (strlen($password) !== strlen($hash)) {
        return false;
    }

    $result = 0;
    for ($i = 0; $i < strlen($password); $i++) {
        $result |= ord($password[$i]) ^ ord($hash[$i]);
    }

    return $result === 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('database.php');  
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        $sql = "SELECT * FROM users WHERE LOWER(username) = LOWER(:username) LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];
            header("Location: ../index.php");
            exit();
        } else {
            $error = "Invalid username or password.";
        }
        
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: url('./images/5.jpg') no-repeat center center fixed;
            background-size: cover;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        main {
            background-color: rgba(255, 255, 255, 0.8); 
            width: 100%;
            max-width: 400px;
            padding: 40px 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-out;
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 14px;
            color: #333;
        }

        input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            width: 100%;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #007BFF;
        }

        button {
            padding: 10px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        p {
            color: red;
            font-size: 14px;
            margin-top: 10px;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.6); /* Semi-transparent black background */
            color: white;
            text-align: center;
            padding: 10px;
            width: 100%;
            margin-top: 20px;
            animation: fadeIn 1s ease-out;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        header {
            margin-bottom: 20px;
        }

        h1 {
            font-size: 30px;
            background: linear-gradient(to right, blue, #004b5c); 
            -webkit-background-clip: text; 
            color: transparent; 
        }

        footer p {
            font-size: 14px;
        }

    </style>
</head>
<body>
    <main>
        <header>
            <h1>Login</h1>
        </header>
        <form action="" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Login</button>
            <p>Don't have an account? <a href="../register.html">Create one here</a>.</p>
        </form>
        
        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
    </main>

    <footer>
        <p>&copy; 2024 Car Showroom</p>
    </footer>
</body>
</html>