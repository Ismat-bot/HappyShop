<?php
session_start();
include "db_config.php";
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "happyshop";

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Check if login form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];

            // Redirect to profile page
            header("Location: profile.php");
            exit();
        } else {
            // Invalid password
            header("Location: signup-page.html"); // Redirect to signup page
            exit();
        }
    } else {
        // User not found
        header("Location: signup-page.html"); // Redirect to signup page
        exit();
    }
}


// Handle Signup Form Submission
if (isset($_POST['signup'])) {
    $fullName = mysqli_real_escape_string($conn, $_POST['full_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Validate password match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match!";
        exit();
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert data into the database
    $sql = "INSERT INTO users (full_name, email, password) VALUES ('$fullName', '$email', '$hashedPassword')";

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful! You can now <a href='index.html'>login</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Handle Login Form Submission
if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if user exists
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Start session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];

            // Redirect to profile page
            header("Location: profile.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with this email.";
    }
}
// Logout Logic
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy session
    header("Location: index.html"); // Redirect to login page
    exit();
}

// Close the connection
$conn->close();
?>
