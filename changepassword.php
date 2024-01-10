<?php

// Function to hash passwords
function password_hash_create($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Function to validate password hashes
function password_hash_validate($password, $hash) {
    return password_verify($password, $hash);
}

// Connect to the database
$servername = "localhost";
$username = "username";
$password = "password";
$dbname = "librarygh";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is logged in
session_start();
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    echo "You need to be logged in to change your password.";
    exit;
}

// Change the password
$id = $_SESSION['id'];
$old_password = $_POST['old_password'];
$new_password = $_POST['new_password'];

$sql = "SELECT password FROM member WHERE id='$id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Get the hashed password from the database
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];

    // Check if the old password matches the hashed password
    if (password_hash_validate($old_password, $hashed_password)) {
        // Update the password in the database
        $new_hashed_password = password_hash_create($new_password);
        $sql = "UPDATE member SET password='$new_hashed_password' WHERE id='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Password changed successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: The old password you entered is incorrect.";
    }
} else {
    echo "Error: No member found with the provided id.";
}

// Close the connection
$conn->close();

?>