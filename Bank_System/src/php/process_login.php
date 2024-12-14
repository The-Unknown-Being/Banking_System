<?php
// Database configuration
$host = 'localhost';
$dbname = 'hamro_bank'; // Replace with your database name
$username = 'root'; // Replace with your database username
$password = ''; // Replace with your database password

// Establish a database connection
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Validate form inputs
    if (empty($username) || empty($password)) {
        die("Both username and password are required.");
    }

    // Query the database for the user
    $stmt = $pdo->prepare("SELECT PasswordHash FROM Users WHERE Username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the user exists and verify the password
    if ($user && password_verify($password, $user['PasswordHash'])) {
        session_start();
        $_SESSION['username'] = $username;
        echo "Login successful! Welcome, $username.";
        // Redirect to the dashboard or home page
        header("Location: ../html/dashboard.html");
        exit;
    } else {
        die("Invalid username or password.");
    }
} else {
    echo "Invalid request.";
}
?>
