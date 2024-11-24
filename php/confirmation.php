<?php
session_start();





include 'database.php';

try {
    // Get the order ID (this could be stored in session after the order is placed)
    $commande_id = $_SESSION['commande_id']; // Assuming you store the order ID in session after the order is created
    
    // Retrieve order details
    $sql = "SELECT c.id, c.total_price, c.status, p.payment_method, p.payment_status 
            FROM commande c 
            JOIN pay p ON c.id = p.commande_id 
            WHERE c.id = :commande_id";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(':commande_id' => $commande_id));
    $order = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$order) {
        echo "Order not found or payment not processed correctly.";
        exit;
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Confirmation</title>
        <style>
            /* Simple styling for the confirmation page */
            body {
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
                background-color: #f4f4f4;
                text-align: center;
            }
            .container {
                max-width: 600px;
                margin: 50px auto;
                background-color: white;
                padding: 20px;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0,0,0,0.1);
            }
            h1 {
                color: #4CAF50;
            }
            .order-details {
                margin-top: 20px;
                text-align: left;
            }
            .order-details p {
                font-size: 18px;
            }
            .back-to-shop {
                margin-top: 30px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Thank You for Your Order!</h1>
            <div class="order-details">
                <p><strong>Order ID:</strong> <?php echo htmlspecialchars($order['id']); ?></p>
                <p><strong>Total Price:</strong> <?php echo htmlspecialchars($order['total_price']); ?> DT</p>
                <p><strong>Status:</strong> <?php echo htmlspecialchars($order['status']); ?></p>
                <p><strong>Payment Method:</strong> <?php echo htmlspecialchars($order['payment_method']); ?></p>
                <p><strong>Payment Status:</strong> <?php echo htmlspecialchars($order['payment_status']); ?></p>
            </div>
            <div class="back-to-shop">
                <a href="index.php">Back to Shop</a>
            </div>
        </div>
    </body>
    </html>
    <?php
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
