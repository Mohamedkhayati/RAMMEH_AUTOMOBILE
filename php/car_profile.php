<?php
include 'database.php';
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';

if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    try {
        // Fetch car details
        $sql = "SELECT * FROM cars WHERE id = :car_id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
        $stmt->execute();
        $car = $stmt->fetch(PDO::FETCH_ASSOC);

        // Fetch car images
        $imageQuery = "SELECT image FROM car_images WHERE car_id = :car_id";
        $imageStmt = $conn->prepare($imageQuery);
        $imageStmt->bindValue(':car_id', $car_id, PDO::PARAM_INT);
        $imageStmt->execute();
        $images = $imageStmt->fetchAll(PDO::FETCH_ASSOC);

        if ($car) {
            ?>
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title><?php echo htmlspecialchars($car['name']); ?> Details</title>
                <link rel="stylesheet" href="car_profile.css">
                <style>
    .gallery-container {
                            max-width: 1200px;
                            margin: 0 auto;
                            padding: 20px;
                        }
    
                        .main-image {
                            text-align: center;
                            margin-bottom: 20px;
                        }
    
                        .main-image img {
                            max-width: 100%;
                            height: auto;
                            border-radius: 10px;
                            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
                        }
    
                        .thumbnail-gallery {
                            display: flex;
                            gap: 10px;
                            justify-content: center;
                            flex-wrap: wrap;
                        }
    
                        .thumbnail-gallery img {
                            width: 100px;
                            height: 100px;
                            object-fit: cover;
                            border: 2px solid transparent;
                            cursor: pointer;
                            transition: 0.3s;
                            border-radius: 5px;
                        }
    
                        .thumbnail-gallery img:hover {
                            border-color: #007bff;
                        }
    
                        .car-details {
                            text-align: center;
                            margin-top: 20px;
                        }
    
                        .car-details h1 {
                            margin-bottom: 10px;
                            font-size: 2rem;
                        }
    
                        .car-details p {
                            margin: 5px 0;
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
                        }                </style>
                <script>
                    // Update the main image when a thumbnail is clicked
                    function updateMainImage(src) {
                        document.getElementById('mainImage').src = src;
                    }
                </script>
            </head>
            <body>
            <header>
                <h1>See car</h1>
                <nav>
                    <a href="../index.php">Home</a>
                    <?php if ($isAdmin): ?>
                        <a href="../add_car.html" id="addCarLink">Add Car</a>
                    <?php endif; ?>
                    <a href="../view_car.php">View Cars</a>
                    <a href="commande.php"><i class="fa-solid fa-cart-shopping"></i> Cart</a>
                </nav>
            </header>

            <div class="gallery-container">
                <?php if ($images): ?>
                    <div class="main-image">
                        <img id="mainImage" src="../images/<?php echo htmlspecialchars($images[0]['image']); ?>" alt="Main Image">
                    </div>
                    <div class="thumbnail-gallery">
                        <?php foreach ($images as $image): ?>
                            <img src="../images/<?php echo htmlspecialchars($image['image']); ?>" alt="Thumbnail" 
                                 onclick="updateMainImage('../images/<?php echo htmlspecialchars($image['image']); ?>')">
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p>No images available for this car.</p>
                <?php endif; ?>

                <div class="car-details">
                    <h1><?php echo htmlspecialchars($car['name']); ?> - <?php echo htmlspecialchars($car['model']); ?></h1>
                    <p><strong>Year:</strong> <?php echo htmlspecialchars($car['year']); ?></p>
                    <p><strong>Price:</strong> <?php echo htmlspecialchars($car['price']); ?> DT</p>
                    <p><strong>Description:</strong> <?php echo htmlspecialchars($car['description']); ?></p>
                    
                    <form method="post" action="add_to_cart.php">
                        <input type="hidden" name="car_id" value="<?php echo $car['id']; ?>">
                        <button type="submit">Add to Cart</button>
                    </form>

                    <?php
                    if (isset($_GET['success'])) {
                        echo '<div style="color: green; margin-top: 10px;">Car added to cart successfully!</div>';
                    } elseif (isset($_GET['error'])) {
                        echo '<div style="color: red; margin-top: 10px;">' . htmlspecialchars($_GET['error']) . '</div>';
                    }
                    ?>
                </div>
            </div>

            </body>
            </html>

            <?php
        } else {
            echo "<p>Car not found.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "<p>No car ID specified.</p>";
}
?>
