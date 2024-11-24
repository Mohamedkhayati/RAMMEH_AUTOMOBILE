<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['car_id'])) {
        $carId = intval($_POST['car_id']);

        try {
            include 'database.php';
            $sql = "SELECT * FROM cars WHERE id = :car_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':car_id', $carId, PDO::PARAM_INT);
            $stmt->execute();
            $car = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($car) {
                if (!isset($_SESSION['cart'])) {
                    $_SESSION['cart'] = array();
                }
                $_SESSION['cart'][] = array(
                    'id' => $car['id'],
                    'name' => $car['name'],
                    'model' => $car['model'],
                    'price' => $car['price'],
                    'description' => $car['description']
                );
                header('Location: car_profile.php?car_id=' . $carId . '&success=1');
                exit();
            } else {
                header('Location: car_profile.php?car_id=' . $carId . '&error=Car not found');
                exit();
            }
        } catch (PDOException $e) {
            header('Location: car_profile.php?car_id=' . $carId . '&error=Database error: ' . $e->getMessage());
            exit();
        }
    } else {
        header('Location: profile_car.php?error=Invalid car ID');
        exit();
    }
} else {
    header('Location: profile_car.php?error=Invalid request method');
    exit();
}
?>
