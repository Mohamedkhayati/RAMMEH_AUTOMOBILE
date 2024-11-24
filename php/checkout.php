<?php
session_start();
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();  // Use array() instead of []
if (empty($cart)) {
    echo "<h2>Your cart is empty.</h2>";
    echo "<a href='../view_car.php'>Go back to browse cars</a>";
    exit;
}

include 'database.php';

try {
    $totalPrice = 0;
    $cartItems = array();  

    foreach ($cart as $item) {
        if (isset($item['quantity']) && is_numeric($item['quantity']) && $item['quantity'] > 0) {
            $cartItems[] = $item['id'];  
            $totalPrice += $item['price'] * $item['quantity']; 
        } else {
            $item['quantity'] = 1;
            $cartItems[] = $item['id']; 
            $totalPrice += $item['price']; 
        }
    }

    $user_id = 1; 
    $sql = "INSERT INTO commande (user_id, total_price) VALUES (:user_id, :total_price)";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':user_id' => $user_id, ':total_price' => $totalPrice));
    $commande_id = $conn->lastInsertId(); 

    foreach ($cart as $item) {
        if (isset($item['quantity']) && is_numeric($item['quantity']) && $item['quantity'] > 0) {
            $sql = "INSERT INTO cart (user_id, car_id, quantity) VALUES (:user_id, :car_id, :quantity)";
            $stmt = $conn->prepare($sql);
            $stmt->execute(array(':user_id' => $user_id, ':car_id' => $item['id'], ':quantity' => $item['quantity']));
        }
    }

    $placeholders = implode(',', array_fill(0, count($cartItems), '?')); 
    $sql = "SELECT * FROM cars WHERE id IN ($placeholders)";
    $stmt = $conn->prepare($sql);
    $stmt->execute($cartItems); 
    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Checkout</title>
        <style>
            .checkout-container {
                max-width: 900px;
                margin: 0 auto;
                padding: 20px;
                text-align: center;
            }
            .cart-summary {
                margin: 20px 0;
            }
            .payment-options {
                margin-top: 30px;
                text-align: left;
            }
            .payment-options label {
                display: block;
                margin-bottom: 10px;
            }
            .payment-options input[type="radio"] {
                margin-right: 10px;
            }
            .checkout-actions {
                margin-top: 30px;
            }
            button {
                padding: 10px 20px;
                background-color: #007bff;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
            }
            button:hover {
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="checkout-container">
            <h1>Checkout</h1>
            <div class="cart-summary">
                <h2>Order Summary</h2>
                <?php foreach ($cars as $car): ?>
                    <p>
                        <?php 
                        $quantity = 1; // Default quantity
                        foreach ($cart as $item) {
                            if ($item['id'] == $car['id']) {
                                $quantity = isset($item['quantity']) ? $item['quantity'] : 1; // Ensure quantity is set
                                break;
                            }
                        }
                        echo htmlspecialchars($car['name']) . " - " . htmlspecialchars($car['price']) . " DT x $quantity";
                        ?>
                    </p>
                <?php endforeach; ?>
                <h3>Total: <?php echo number_format($totalPrice, 2); ?> DT</h3>
            </div>
            <div class="payment-options">
                <h2>Payment Options</h2>
                <form action="process_payment.php" method="post">
                    <input type="hidden" name="commande_id" value="<?php echo $commande_id; ?>">
                    <label>
                        <input type="radio" name="payment_method" value="credit_card" required>
                        Credit Card
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="bank_transfer">
                        Bank Transfer
                    </label>
                    <label>
                        <input type="radio" name="payment_method" value="cash_on_delivery">
                        Cash on Delivery
                    </label>
                    <div class="checkout-actions">
                        <button type="submit">Confirm Payment</button>
                    </div>
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
