<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Showroom</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }

        .car-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            padding: 20px;
        }

        .car {
            width: 300px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .car:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .car img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .car h3 {
            margin: 10px;
            font-size: 18px;
            color: #333;
        }

        .car p {
            margin: 10px;
            color: #666;
            font-size: 14px;
        }

        .car a {
            text-decoration: none;
            color: inherit;
        }

        .search-bar {
            text-align: center;
            margin: 20px 0;
        }

        .search-bar input[type="text"] {
            width: 50%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .search-bar button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            background-color: #007BFF;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search for cars" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit">Search</button>
        </form>
    </div>
    <?php
    include 'database.php';

    try {
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // SQL query for fetching cars
        if (!empty($search)) {
            $sql = "SELECT * FROM cars WHERE approved = 1 AND (name LIKE :search OR model LIKE :search OR description LIKE :search)";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        } else {
            $sql = "SELECT * FROM cars WHERE approved = 1";
            $stmt = $conn->prepare($sql);
        }

        $stmt->execute();
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($cars) > 0) {
            echo "<div class='car-list'>";
            foreach ($cars as $car) {
                // Fetch the first image for the current car from the car_images table
                $imageSql = "SELECT image FROM car_images WHERE car_id = :car_id LIMIT 1";
                $imageStmt = $conn->prepare($imageSql);
                $imageStmt->bindParam(':car_id', $car['id'], PDO::PARAM_INT);
                $imageStmt->execute();
                $image = $imageStmt->fetch(PDO::FETCH_ASSOC);

                echo "<div class='car'>";
                if ($image && file_exists('./images/' . $image['image'])) {
                    $imagePath = './images/' . htmlspecialchars($image['image']);
                    echo "<a href='./php/car_profile.php?car_id=" . urlencode($car['id']) . "'>";
                    echo "<img src='$imagePath' alt='" . htmlspecialchars($car['name']) . "'>";
                    echo "</a>";
                } else {
                    echo "<p>No image available for this car.</p>";
                }

                echo "<h3>" . htmlspecialchars($car['name']) . " - " . htmlspecialchars($car['model']) . "</h3>";
                echo "<p>Year: " . htmlspecialchars($car['year']) . "</p>";
                echo "<p>Price: " . htmlspecialchars($car['price']) . " DT</p>";
                echo "<p>" . htmlspecialchars($car['description']) . "</p>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p style='text-align: center; font-size: 18px; color: #666;'>No cars found.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>
</body>
</html>
