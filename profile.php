<?php
session_start();
include "db_config.php"
// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html"); // Redirect to login page if not logged in
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "happyshop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch order details for the logged-in user (if you have an orders table)
$userId = $_SESSION['user_id'];
$orderQuery = "SELECT * FROM orders WHERE user_id = $userId"; // Modify according to your DB structure
$orderResult = $conn->query($orderQuery);
// Fetch user details from the session
$userId = $_SESSION['user_id'];
$fullName = $_SESSION['full_name'];
$email = $_SESSION['email'];
// Fetch user details
$userQuery = "SELECT * FROM users WHERE id = $userId";
$userResult = $conn->query($userQuery);
$user = $userResult->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>User Profile</title>
</head>
<body>
<div class="profile-container">
    <h1>Welcome, <?php echo $fullName; ?>!</h1>
    <p><strong>User ID:</strong> <?php echo $userId; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>


    <h2>Your Orders</h2>
    <p>Order details can be displayed here.</p>
        <?php if ($orderResult->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Order Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($order = $orderResult->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $order['id']; ?></td>
                            <td><?php echo $order['product_name']; ?></td>
                            <td><?php echo $order['quantity']; ?></td>
                            <td><?php echo $order['price']; ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have no orders yet.</p>
        <?php endif; ?>

        <a href="auth.php?logout=true">Logout</a>
    </div>
</body>
</html>
