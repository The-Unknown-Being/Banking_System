<?php
// Database configuration
$host = 'localhost';
$dbname = 'hamro_bank';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $fullName = htmlspecialchars($_POST['fullname']);
    $email = htmlspecialchars($_POST['email']);
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirm-password']);
    $dob = htmlspecialchars($_POST['dob']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);

    // Validate form inputs
    if (empty($fullName) || empty($email) || empty($username) || empty($password) || empty($dob) || empty($phone) || empty($address)) {
        die("All fields are required.");
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format.");
    }
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Check if the username or email already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE Username = :username OR Email = :email");
    $stmt->execute([':username' => $username, ':email' => $email]);
    if ($stmt->fetchColumn() > 0) {
        die("Username or email is already taken.");
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Insert the user into the database
    try {
        $stmt = $pdo->prepare("INSERT INTO Users (Username, PasswordHash, FullName, Email, DateOfBirth, Phone, Address) 
                               VALUES (:username, :password, :fullname, :email, :dob, :phone, :address)");
        $stmt->execute([
            ':username' => $username,
            ':password' => $hashedPassword,
            ':fullname' => $fullName,
            ':email' => $email,
            ':dob' => $dob,
            ':phone' => $phone,
            ':address' => $address
        ]);
        echo "Sign-up successful! You can now <a href='../html/login.html'>log in</a>.";
    } catch (PDOException $e) {
        die("Error saving user: " . $e->getMessage());
    }
} else {
    echo "Invalid request.";
}
?>
