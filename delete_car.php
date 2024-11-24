<?php
session_start();
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

// Check if user is logged in and has admin privileges
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ./php/login.php");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "car_showroom");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle car deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['car_id'])) {
    $carId = intval($_POST['car_id']);
    $sql = "DELETE FROM cars WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $carId);
    
    if ($stmt->execute()) {
        $message = "Car successfully deleted.";
    } else {
        $message = "Error deleting car: " . $conn->error;
    }
    $stmt->close();
}

// Fetch cars
$carsQuery = "SELECT * FROM cars";
$result = $conn->query($carsQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Cars</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background: url('images/9.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
        }

        header {
            background-color: black;
            color: white;
            padding: 15px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: black;
            color: white;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .delete-btn {
            background-color: red;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-btn:hover {
            background-color: darkred;
        }

        .message {
            text-align: center;
            margin: 20px;
            color: green;
        }

        footer {
            background-color: black;
            color: white;
            text-align: center;
            padding: 10px;
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
        h1 {
            margin-bottom: 20px;
            font-size: 30px;
            color: #333;
        }
        
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
    animation: fadeIn 1s ease-out;
}

header .logo {
    width: 150px; 
    height: auto;
    margin-left: 20px;
}
table {
    animation: fadeIn 1s ease-out;

}

header h1 {
    flex: 1;
    text-align: center;
    font-size: 30px;
    position: absolute;
    left: 640px;
}

nav {
    display: flex;
    justify-content: center;
    gap: 20px;
}

nav a {
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

.car-container {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 10px;
    margin-top: 20px;
}

.car-card {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    background-color: #f8f8f8;
    animation: fadeIn 1s ease-out;
}

.car-card img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 10px;
    transition: transform 0.3s ease-in-out;
}

.car-card:hover img {
    transform: scale(1.1);
}
footer {
    background-color: black;
    color: white;
    text-align: center;
    padding: 10px;
    margin-top: 20px;
    animation: fadeIn 1s ease-out;
}

#addCarLink {
    background-color: #007BFF;
    color: white;
    border-radius: 5px;
    padding: 10px 15px;
    font-weight: bold;
    text-decoration: none;
    transition: background-color 0.3s;
}

#addCarLink:hover {
    background-color: #0056b3;
}

h2 {
    color: darkred;
}

.showroom-info {
    display: flex;
    justify-content: center;
    gap: 40px;
    margin-top: 40px;
}

.showroom-info div {
    text-align: center;
}

.showroom-info i {
    font-size: 40px;
    margin-bottom: 10px;
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

    </style>
</head>
<body>
    <header>
        <h1>Delete Cars</h1>
        <nav>
            <a href="index.php">Home</a>
            <?php if ($isAdmin): ?>
                    <a href="add_car.html" id="addCarLink">Add Car</a>
                <?php endif; ?>
        </nav>
        
    </header>
    
    <?php if (isset($message)): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <table>
        <tr>
            <th>ID</th>
            <th>Car Name</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($car = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($car['id']); ?></td>
                    <td><?php echo htmlspecialchars($car['name']); ?></td>
                    <td><?php echo htmlspecialchars($car['price']); ?></td>
                    <td>
                        <form method="POST" action="delete_car.php">
                            <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car['id']); ?>">
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="4">No cars available.</td>
            </tr>
        <?php endif; ?>
    </table>

    <footer>
        <p>&copy; 2024 Car Showroom</p>
    </footer>
</body>
</html>

<?php $conn->close(); ?>
