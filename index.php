<?php

require_once "config/db.php";

$sql = "SELECT * FROM destinations";
$result = $conn->query($sql);
$package_sql = "SELECT * FROM packages";
$package_result = $conn->query($package_sql);

session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Travel Website</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background-color: #f5f5f5;
        }

        header {
            background-color: #2196f3;
            color: white;
            padding: 20px;
            text-align: center;
        }

        h1 {
            margin: 0;
        }

        .container {
            width: 90%;
            max-width: 1100px;
            margin: 30px auto;
        }

        .destinations {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .card h2 {
            margin-top: 0;
            color: #2196f3;
        }

        .location {
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .destinations {
                grid-template-columns: 1fr;
            }
        }
        nav {
    background-color: #023e8a;
    padding: 15px;
    text-align: center;
}

nav a {
    color: white;
    text-decoration: none;
    margin: 0 15px;
    font-weight: bold;
}

nav a:hover {
    text-decoration: underline;
}
    </style>
</head>

<body>
    <nav style="padding: 15px; text-align: right; background: #ffffff;">

    <?php if (isset($_SESSION["user_id"])): ?>

        Welcome, <?php echo htmlspecialchars($_SESSION["user_name"]); ?> |
        <a href="logout.php">Logout</a>

    <?php else: ?>

        <a href="login.php">Login</a> |
        <a href="register.php">Register</a>

    <?php endif; ?>

</nav>
    <nav>
        <a href="index.php">Home</a>
        <a href="destinations.php">Destinations</a>
        <a href="packages.php">Packages</a>
        <a href="login.php">Login</a>
        <a href="register.php">Register</a>
    </nav>

<header>
    <h1>🌍 Travel Website</h1>
    <p>Explore Beautiful Destinations</p>
</header>

<div class="container">

    <h2>Popular Destinations</h2>

    <div class="destinations">

        <?php while ($destination = $result->fetch_assoc()) { ?>

            <div class="card">

                <h2>
                    <?php echo htmlspecialchars($destination['name']); ?>
                </h2>

                <p class="location">
                    📍 <?php echo htmlspecialchars($destination['location']); ?>
                </p>

                <p>
                    <?php echo htmlspecialchars($destination['description']); ?>
                </p>

            </div>

        <?php } ?>

    </div>
    <h2>Travel Packages</h2>

<div class="destinations">

    <?php while ($package = $package_result->fetch_assoc()) { ?>

        <div class="card">

            <h2>
                <?php echo htmlspecialchars($package['package_name']); ?>
            </h2>

            <p>
                <?php echo htmlspecialchars($package['description']); ?>
            </p>

            <p>
                💰 Price: ₹<?php echo htmlspecialchars($package['price']); ?>
            </p>

            <p>
                🕒 Duration: <?php echo htmlspecialchars($package['duration']); ?>
            </p>

        </div>

    <?php } ?>

</div>

</div>

</body>
</html>