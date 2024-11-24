<?php
session_start();
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Showroom</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
   <link rel="stylesheet" href="./css/styles.css">
</head>
<body>
    <header>
        <img src="images/rammeh.jpg" alt="Car Showroom Logo" class="logo">
        <h1> RAMMEH AUTOMOBILES</h1>
        <nav>
            <?php if (!isset($_SESSION['username'])): ?>
                <a href="./php/login.php">Login</a>
            <?php else: ?>
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <?php if ($isAdmin): ?>
                    <a href="add_car.html" id="addCarLink">Add Car</a>
                    <a href="delete_car.php" id="deleteCarLink">Delete Car</a>
                <?php endif; ?>
                <a href="view_car.php">View Cars</a>
                <a href="./php/logout.php">Logout</a>
            <?php endif; ?>
        </nav>
    </header>

    
    
    <main>
        <h2>WELCOME TO OUR HIGH -END CAR SHOWROOM</h2>
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
                <i class="fa fa-phone-alt"></i>
                <p>Call us: 58 229 563</p>
            </div>
            <div>
                <i class="fa fa-map-marker-alt"></i>
                <p>Address: Hammamet, Nabeul, Tunisia</p>
            </div>
        </div>
    </main>
    
    <footer>
        <p>&copy; 2024 Car Showroom</p>
    </footer>
</body>
</html>
