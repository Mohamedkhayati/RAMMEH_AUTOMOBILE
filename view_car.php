<?php
session_start();
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cars</title>
    <link rel="shortcut icon" href="images/rammeh.jpg">

    <style>
/* General Styles */
* {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
    animation: fadeIn 1s ease-in;
    
}

header {
    padding: 10px 20px;
    text-align: center;
    display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: black;
            color: white;
            padding: 20px;
            animation: fadeIn 1s ease-out;
}

header h1 {
    margin: 0;
    flex: 1;
            text-align: center;
            font-size: 30px;
            position: absolute;
            left: 540px;
}

nav {
    margin-top: 10px;
    display: flex;
            justify-content: center;
            gap: 20px;
}

nav a {

    margin: 0 10px;
    color: white;
            text-decoration: none;
            font-weight: bold;
            padding: 10px 15px;
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
            text-align: center;
            background-color: white;
            animation: fadeIn 1s ease-out;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 30px;
            color: #333;
        }

footer {
    text-align: center;
    background: #333;
    color: #fff;
    padding: 10px 0;
    margin-top: 20px;
}

.car-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    padding: 20px;
    gap: 20px;
}

.car-card {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s, box-shadow 0.3s;
    width: 300px; 
    height: 400px; 
    display: flex;
    flex-direction: column;
    justify-content: flex-start; 
    animation: cardFadeIn 1s ease-out;
}

.car-card:hover {
    transform: scale(1.05);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
}

.car-card img {
    width: 100%;
    height: 200px; 
    object-fit: cover; 
    border-bottom: 2px solid #ff5733;
    transition: transform 0.3s ease;
}

.car-card:hover img {
    transform: scale(1.1); 
}


.car-info {
    padding: 15px;
    text-align: center;
    flex-grow: 1; 
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.car-info h3 {
    margin: 10px 0;
    font-size: 1.2em;
    color: #ff5733;
}

.car-info p {
    margin: 5px 0;
    color: #555;
    font-size: 0.9em; 
    line-height: 1.4; 
}

@keyframes fadeIn {
    0% { opacity: 0; }
    100% { opacity: 1; }
}


@keyframes cardFadeIn {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

    </style>
</head>
<body>
    <header>
        
        <h1>Available Cars</h1>
        <nav>
            <a href="index.php">Home</a>
            <?php if ($isAdmin): ?>
                    <a href="add_car.html" id="addCarLink">Add Car</a>
                <?php endif; ?>
        </nav>
    </header>
    <main>
        <div class="car-list">
            <?php include 'php/view_cars.php'; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Car Showroom</p>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>
