<?php
include 'Database.php';
include 'User.php';

// Check if the form has been submitted and if matric is provided
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['matric'])) {
    // Retrieve the matric value from the GET request
    $matric = $_GET['matric'];

    // Create an instance of the Database class and get the connection
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);
    $userDetails = $user->getUser($matric);

    // Check if user details were retrieved successfully
    if ($userDetails) {
        $db->close();

        // Display the update form with the fetched user data
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Update User</title>
        </head>

        <body>
            <form action="Update.php" method="post">
                <input type="hidden" name="matric" value="<?php echo htmlspecialchars($userDetails['matric']); ?>">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($userDetails['name']); ?>"><br>
                <label for="role">Role:</label>
                <select name="role" id="role" required>
                    <option value="">Please select</option>
                    <option value="lecturer" <?php if ($userDetails['role'] == 'lecturer') echo "selected"; ?>>Lecturer</option>
                    <option value="student" <?php if ($userDetails['role'] == 'student') echo "selected"; ?>>Student</option>
                </select><br>
                <input type="submit" value="Update">
                <br><a href="read.php">Cancel</a>
            </form>
        </body>

        </html>
<?php
    } else {
        echo "User not found.";
    }
} else {
    echo "Matric parameter is missing.";
}
?>