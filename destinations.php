<?php
require_once 'config/db.php';
$sql = "SELECT * FROM destinations";
$result = $conn->query($sql);
?>
<?php
require_once "config/db.php";

$result = $conn->query("SELECT * FROM destinations");
?>

<!DOCTYPE html>
<html>

<head>
    <title>Destinations</title>
</head>

<body>

    <h1>Travel Destinations</h1>

    <?php while ($row = $result->fetch_assoc()) { ?>

        <div>
            <h2><?php echo $row['name']; ?></h2>
            <p><strong>Location:</strong> <?php echo $row['location']; ?></p>
            <p><?php echo $row['description']; ?></p>
        </div>

        <hr>

    <?php } ?>

</body>

</html>