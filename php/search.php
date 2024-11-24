<?php
session_start();
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Showroom - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: black;
            color: white;
            padding: 20px;
        }

        header .logo {
            width: 150px;
            height: auto;
        }

        header h1 {
            flex: 1;
            text-align: center;
            font-size: 30px;
            color: white;
        }

        nav {
            display: flex;
            gap: 15px;
        }

        nav a {
            color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: red;
        }

        nav span {
            color: white;
        }

        main {
            padding: 20px;
            background-color: white;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 28px;
            color: darkred;
        }

        .car-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .car-card {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            background-color: #f8f8f8;
        }

        .car-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
        }

     
        .showroom-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .showroom-info div {
            text-align: center;
        }

        .showroom-info i {
            font-size: 40px;
            margin-bottom: 10px;
            color: darkred;
        }

        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px;
            margin-top: 20px;
        }


        #addCarLink {
            background-color: #007BFF;
            color: white;
            border-radius: 5px;
            padding: 10px 15px;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        #addCarLink:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <img src="images/rammeh.jpg" alt="Car Showroom Logo" class="logo">
        <h1>RAMMEH AUTOMOBILES</h1>
        <nav>
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="./php/login.php">Login</a>
                <a href="./php/register.php">Sign Up</a>
            <?php else: ?>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <?php if ($isAdmin): ?>
                    <a href="add_car.html" id="addCarLink">Add Car</a>
                <?php endif; ?>
                <a href="view_car.php">View Cars</a>
                <a href="./php/logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <h2>WELCOME TO OUR HIGH-END CAR SHOWROOM</h2>
        <div class="car-container">
            <div class="car-card"><img src="images/1.jpg" alt="Car 1"></div>
            <div class="car-card"><img src="images/2.jpg" alt="Car 2"></div>
            <div class="car-card"><img src="images/3.jpg" alt="Car 3"></div>
            <div class="car-card"><img src="images/4.jpg" alt="Car 4"></div>
        </div>

        <div class="showroom-info">
            <div>
                <i class="fa-brands fa-facebook"></i>
                <p><a href="https://www.facebook.com/profile.php?id=100083468045994" target="_blank">Follow us on Facebook</a></p>
            </div>
            <div>
                <i class="fa-brands fa-instagram"></i>
                <p><a href="https://www.instagram.com/rammehautomobile/?hl=en" target="_blank">Follow us on Instagram</a></p>
            </div>
            <div>
                <i class="fa fa-phone"></i>
                <p>Call us: 58 229 563</p>
            </div>
            <div>
                <i class="fa fa-map-marker-alt"></i>
                <p>Address: Hammamet, Nabeul, Tunisia</p>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 RAMMEH AUTOMOBILES. All rights reserved.</p>
    </footer>
</body>
</html>
