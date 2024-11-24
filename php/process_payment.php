<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Replace [] with array() for compatibility with PHP 5.3
    $paymentMethods = array();  // Replace with array()

    // Check if payment method is selected
    if (isset($_POST['payment_method'])) {
        $paymentMethod = $_POST['payment_method'];
    } else {
        echo "Please select a payment method.";
        exit;
    }

    // Process the payment (e.g., using a third-party API, etc.)
    // Here we simulate the process for demonstration purposes:
    try {
        include 'database.php';
        
        // Assuming you have a table to record payment information
        $commande_id = $_POST['commande_id'];  // Retrieve the order ID from the form
        $payment_status = "Pending";  // Default status for payment
        
        // Insert payment details into the payment table
        $sql = "INSERT INTO pay (commande_id, payment_method, payment_status) 
                VALUES (:commande_id, :payment_method, :payment_status)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':commande_id' => $commande_id, ':payment_method' => $paymentMethod, ':payment_status' => $payment_status));
        
        // Update the order status to "paid" (or any other status as needed)
        $sql = "UPDATE commande SET status = 'Paid' WHERE id = :commande_id";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':commande_id' => $commande_id));
        
        // Redirect to a confirmation page or show success message
        header("Location: confirmation.php");
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
