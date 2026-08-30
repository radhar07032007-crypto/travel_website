<?php
session_start();
require_once "config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: index.php");
    exit();
}

if (
    !isset($_POST['package_id']) ||
    !isset($_POST['booking_date']) ||
    !isset($_POST['number_of_people'])
) {
    die("Invalid booking details.");
}

$user_id = $_SESSION['user_id'];
$package_id = intval($_POST['package_id']);
$booking_date = $_POST['booking_date'];
$number_of_people = intval($_POST['number_of_people']);

if ($number_of_people < 1) {
    die("Number of people must be at least 1.");
}

/* Get package price */
$stmt = $conn->prepare(
    "SELECT package_name, price, duration
     FROM packages
     WHERE id = ?"
);

$stmt->bind_param("i", $package_id);
$stmt->execute();

$result = $stmt->get_result();
$package = $result->fetch_assoc();

if (!$package) {
    die("Package not found.");
}

/* Calculate total price */
$total_price = $package['price'] * $number_of_people;

/* Insert booking */
$stmt = $conn->prepare(
    "INSERT INTO bookings
    (user_id, package_id, booking_date, number_of_people, total_price, status)
    VALUES (?, ?, ?, ?, ?, 'Pending')"
);

$stmt->bind_param(
    "iisid",
    $user_id,
    $package_id,
    $booking_date,
    $number_of_people,
    $total_price
);

if ($stmt->execute()) {
    $booking_id = $conn->insert_id;
} else {
    die("Booking failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Booking Successful</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f9ff;
            text-align: center;
            padding: 50px;
        }

        .success-box {
            background: white;
            max-width: 600px;
            margin: auto;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        h1 {
            color: #2196f3;
        }

        .details {
            text-align: left;
            margin-top: 25px;
            line-height: 2;
        }

        .btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 25px;
            background: #2196f3;
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        .btn:hover {
            background: #1976d2;
        }
    </style>
</head>

<body>

<div class="success-box">

    <h1>🎉 Booking Successful!</h1>

    <p>Your trip has been booked successfully.</p>

    <div class="details">

        <strong>Booking ID:</strong>
        <?php echo $booking_id; ?>
        <br>

        <strong>Package:</strong>
        <?php echo htmlspecialchars($package['package_name']); ?>
        <br>

        <strong>Travel Date:</strong>
        <?php echo htmlspecialchars($booking_date); ?>
        <br>

        <strong>Number of People:</strong>
        <?php echo $number_of_people; ?>
        <br>

        <strong>Price per Person:</strong>
        ₹<?php echo number_format($package['price'], 2); ?>
        <br>

        <strong>Total Price:</strong>
        ₹<?php echo number_format($total_price, 2); ?>
        <br>

        <strong>Status:</strong>
        Pending

    </div>

    <a href="index.php" class="btn">Back to Home</a>

</div>

</body>
</html>