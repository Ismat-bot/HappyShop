<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "happyshop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Array of user data for login
$loginData = [
    ['user1@example.com', 'password1'],
    ['user2@example.com', 'password2'],
    ['user3@example.com', 'password3'],
    ['user4@example.com', 'password4'],
    ['user5@example.com', 'password5']
];

// Insert login data
foreach ($loginData as $data) {
    $email = $data[0];
    $password = password_hash($data[1], PASSWORD_DEFAULT); // Hash the password for security

    $sql = "INSERT INTO users (email, password) VALUES ('$email', '$password')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Array of user data for signup
$signupData = [
    [1, 'Alice Johnson', 'alice@example.com', 'alice123'],
    [2, 'Bob Smith', 'bob@example.com', 'bob123'],
    [3, 'Charlie Brown', 'charlie@example.com', 'charlie123'],
    [4, 'David Clark', 'david@example.com', 'david123'],
    [5, 'Emma White', 'emma@example.com', 'emma123']
];

// Insert signup data
foreach ($signupData as $data) {
    $id = $data[0];
    $fullName = $data[1];
    $email = $data[2];
    $password = password_hash($data[3], PASSWORD_DEFAULT); // Hash the password for security

    $sql = "INSERT INTO users (id, full_name, email, password) VALUES ($id, '$fullName', '$email', '$password')";
    if ($conn->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

echo "Data inserted successfully!";
$conn->close();
?>
