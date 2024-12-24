<?php
session_start();

include 'Database.php';
include 'User.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matric = $_POST['matric'];
    $password = $_POST['password'];

    // Create database connection
    $database = new Database();
    $db = $database->getConnection();

    // // Sanitize inputs using mysqli_real_escape_string
    // $matric = $db->real_escape_string($_POST['matric']);
    // $password = $db->real_escape_string($_POST['password']);

    // // Validate inputs
    // if (!empty($matric) && !empty($password)) {
    $user = new User($db);
    $userDetails = $user->getUser($matric);

    // Check if user exists and verify password
    if ($userDetails && password_verify($password, $userDetails['password'])) {
        $_SESSION['loggedin'] = true; // Set session variable
        $_SESSION['matric'] = $userDetails['matric']; // Store matric number in session
        // Redirect to display page upon successful login
        header("Location: Read.php");
    } else {
        echo "Invalid credentials! Please try again.";
        echo '<br><a href="login.php">Back to Login</a>';
    }
} else {
    echo 'Please fill in all required fields.';
    // }
}
