<?php
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $target_dir = "../images/";
    $images = array(); 

    foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
        $file_name = basename($_FILES['images']['name'][$key]);
        $target_file = $target_dir . $file_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($tmp_name);
        if ($check === false) {
            echo "File $file_name is not an image.";
            exit;
        }

        if (file_exists($target_file)) {
            echo "Sorry, file $file_name already exists.";
            exit;
        }

        if ($_FILES['images']['size'][$key] > 500000) {
            echo "Sorry, file $file_name is too large.";
            exit;
        }

        if (!in_array($imageFileType, array('jpg', 'jpeg', 'png', 'gif'))) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            exit;
        }

        if (move_uploaded_file($tmp_name, $target_file)) {
            $images[] = $file_name; 
        } else {
            echo "Sorry, there was an error uploading file $file_name.";
            exit;
        }
        if (isset($_GET['success'])) {
                        echo '<div style="color: green; margin-top: 10px;">Car added to cart successfully!</div>';
    }

    try {
        $conn->beginTransaction();
        $sql = "INSERT INTO cars (name, model, year, price, description, approved) 
                VALUES (:name, :model, :year, :price, :description, 1)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':model', $model);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->execute();

        $car_id = $conn->lastInsertId();
        $image_sql = "INSERT INTO car_images (car_id, image) VALUES (:car_id, :image)";
        $image_stmt = $conn->prepare($image_sql);
        foreach ($images as $image) {
            $image_stmt->bindParam(':car_id', $car_id);
            $image_stmt->bindParam(':image', $image);
            $image_stmt->execute();
        }

        $conn->commit();
        echo "New car and images added successfully!";
    } catch (PDOException $e) {
        $conn->rollBack();
        echo "Error: " . $e->getMessage();
    }
}}
?>
