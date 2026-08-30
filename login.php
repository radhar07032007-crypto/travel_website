<?php
session_start();
require_once "config/db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        if (password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            header("Location: index.php");
            exit();

        } else {
            $message = "Incorrect password.";
        }

    } else {
        $message = "Email not registered.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login - Travel Website</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            text-align: center;
            padding-top: 60px;
        }

        .login-box {
            width: 400px;
            margin: auto;
            background: white;
            padding: 35px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h1 {
            color: #2196f3;
        }

        input {
            width: 90%;
            padding: 12px;
            margin: 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
        }

        button {
            width: 95%;
            padding: 12px;
            background: #20b9d5;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
        }

        .error {
            color: red;
        }

        a {
            color: #2196f3;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h1>Login</h1>

    <?php if ($message != ""): ?>
        <p class="error"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">

        <input
            type="email"
            name="email"
            placeholder="Enter your email"
            required
        >

        <input
            type="password"
            name="password"
            placeholder="Enter your password"
            required
        >

        <button type="submit">Login</button>

    </form>

    <p>
        Don't have an account?
        <a href="register.php">Create Account</a>
    </p>

</div>

</body>
</html>