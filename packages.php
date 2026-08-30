<?php
require_once "config/db.php";

$sql = "SELECT packages.*, destinations.name AS destination_name
        FROM packages
        JOIN destinations ON packages.destination_id = destinations.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Travel Packages</title>
</head>

<body>

    <h1>Travel Packages</h1>

    <?php while ($row = $result->fetch_assoc()) { ?>

        <div>
            <h2>
                <?php echo $row['package_name']; ?>
            </h2>

            <p>
                <strong>Destination:</strong>
                <?php echo $row['destination_name']; ?>
            </p>

            <p>
                <?php echo $row['description']; ?>
            </p>

            <p>
                <strong>Price:</strong>
                ₹
                <?php echo $row['price']; ?>
            </p>

            <p>
                <strong>Duration:</strong>
                <?php echo $row['duration']; ?>
            </p>

            <a href="booking.php?package_id=<?php echo $row['id']; ?>">
                Book Now
            </a>
        </div>

        <hr>

    <?php } ?>

</body>

</html>