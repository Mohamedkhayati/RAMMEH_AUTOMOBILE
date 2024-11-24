<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <section>
            <h2>Pending Car Approvals</h2>
            <div class="car-list">
                <?php include 'php/admin.php'; ?>
            </div>
        </section>
        <section>
            <h2>Manage Users</h2>
            <div class="user-list">
                <?php include 'php/manage_users.php'; ?>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Car Showroom</p>
    </footer>
    <script src="js/script.js"></script>
</body>
</html>
