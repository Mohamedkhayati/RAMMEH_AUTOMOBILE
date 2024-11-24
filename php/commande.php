<?php
session_start();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (empty($cart)) {
    echo "<h2>Your cart is empty.</h2>";
    echo "<a href='../view_car.php'>Go back to browse cars</a>";
    exit;
}

include 'database.php';

try {
    $placeholders = '';
    $params = array();

    foreach ($cart as $index => $item) {
        $placeholders .= ':id' . $index . ',';
        $params[':id' . $index] = $item['id'];
    }

    $placeholders = rtrim($placeholders, ',');

    $sql = "
        SELECT cars.*, car_images.image 
        FROM cars
        LEFT JOIN car_images ON cars.id = car_images.car_id
        WHERE cars.id IN ($placeholders)
        GROUP BY cars.id
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $totalPrice = array_sum(array_map(function ($car) {
        return $car['price'];
    }, $cars));

    if (isset($_POST['remove_id'])) {
        $remove_id = $_POST['remove_id'];

        foreach ($cart as $index => $item) {
            if ($item['id'] == $remove_id) {
                unset($_SESSION['cart'][$index]); 
                $_SESSION['cart'] = array_values($_SESSION['cart']); 
                error_log("Removed car ID: $remove_id");
                header("Location: " . $_SERVER['PHP_SELF']);
                exit;
            }
        }
    }

    if (isset($_POST['checkout'])) {
        header("Location: checkout.php");
        exit;
    }
?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Summary</title>
        <style>
            .commande-container {
                max-width: 900px;
                margin: 0 auto;
                padding: 20px;
                text-align: center;
            }
            .car-item {
                border: 1px solid #ddd;
                padding: 10px;
                margin: 10px 0;
                display: flex;
                align-items: center;
                gap: 20px;
            }
            .car-item img {
                width: 120px;
                height: auto;
                border-radius: 8px;
            }
            .total-price {
                font-size: 20px;
                font-weight: bold;
                margin-top: 20px;
            }
            .buttons {
                margin-top: 20px;
                display: flex;
                justify-content: center;
                gap: 20px;
            }
            .button {
                padding: 10px 20px;
                font-size: 16px;
                cursor: pointer;
                border: none;
                background-color: #4CAF50;
                color: white;
                border-radius: 5px;
            }
            .button-delete {
                background-color: #f44336;
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
        </style>
    </head>
    <header>
                <h1>Order Summary</h1>
                <nav>
                    <a href="../index.php">Home</a>
                    <?php if ($isAdmin): ?>
                        <a href="../add_car.html" id="addCarLink">Add Car</a>
                    <?php endif; ?>
                    <a href="../view_car.php">View Cars</a>
                    <a href="commande.php"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
                </nav>
            </header>
    <body>
        <div class="commande-container">
            

            <h1>Order Summary</h1>
            <?php foreach ($cars as $car): ?>
                <div class="car-item">
                    <img src="../images/<?php echo htmlspecialchars($car['image']); ?>" alt="<?php echo htmlspecialchars($car['name']); ?>">
                    <div>
                        <h3><?php echo htmlspecialchars($car['name']); ?></h3>
                        <p>Price: <?php echo htmlspecialchars($car['price']); ?> DT</p>
                        <form method="POST" action="" style="display:inline;">
                            <input type="hidden" name="remove_id" value="<?php echo $car['id']; ?>"> <!-- Use car's ID here -->
                            <button type="submit" class="button button-delete">Remove</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
            <div class="total-price">Total: <?php echo $totalPrice; ?> DT</div>
            <div class="buttons">
                <form method="POST" action="">
                    <button type="submit" name="checkout" class="button">Proceed to Checkout</button>
                </form>
            </div>
        </div>
    </body>
    </html>
<?php
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
