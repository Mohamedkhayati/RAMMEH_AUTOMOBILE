<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Cars</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Search Cars</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="login.html">Login</a>
            <a href="signup.html">Sign Up</a>
        </nav>
    </header>
    <main>
        <form action="php/search.php" method="get">
            <label for="query">Search for a car:</label>
            <input type="text" id="query" name="query" required>
            <button type="submit">Search</button>
        </form>
        <div class="car-list">
            <?php include 'php/search.php'; ?>
        </div>
    </main>
    <footer>
        <p>&copy; 2024 Car Showroom</p>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>
