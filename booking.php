<?php
session_start();

require_once __DIR__ . '/config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['package_id'])) {
    die("Package not selected.");
}

$package_id = intval($_GET['package_id']);

$stmt = $conn->prepare(
    "SELECT id, package_name, price, duration
     FROM packages
     WHERE id = ?"
);

$stmt->bind_param("i", $package_id);
$stmt->execute();

$result = $stmt->get_result();
$package = $result->fetch_assoc();

$stmt->close();

if (!$package) {
    die("Package not found.");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Package</title>
</head>

<body>

    <h1>Book Your Trip</h1>

    <h2>
        <?php echo htmlspecialchars($package['package_name']); ?>
    </h2>

    <p>
        <strong>Price:</strong>
        ₹<?php echo number_format($package['price'], 2); ?>
    </p>

    <p>
        <strong>Duration:</strong>
        <?php echo htmlspecialchars($package['duration']); ?>
    </p>

    <form method="POST" action="booking_success.php">

        <input type="hidden" name="package_id" value="<?php echo $package['id']; ?>">

        <label>Travel Date:</label>
        <input type="date" name="booking_date" required>

        <br><br>

        <label>Number of People:</label>
        <input type="number" name="number_of_people" min="1" value="1" required>

        <br><br>

        <button type="submit">
            Confirm Booking
        </button>

    </form>

</body>

</html>