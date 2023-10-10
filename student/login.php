<?php
require_once ("settings.php");

// Create a connection
$conn = @mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// Retrieve user input
$username = $_POST["username"];
$password = $_POST["password"];
$role = $_POST["role"];

// SQL query to validate user credentials
if ($role == "student"){
    $sql = "SELECT * FROM STUDENT WHERE username='$username' AND password='$password' ";
    $result = $conn->query($sql);
}
else{
    $sql = "SELECT * FROM STAFF WHERE username='$username' AND password='$password' AND role='$role'";
    $result = $conn->query($sql);
}


if ($result->num_rows > 0) {

    //Fetch the row
    $row = $result->fetch_assoc();
    $staffid = $row['staffid'];

    // Save username to session storage
    $_SESSION["username"] = $username;
    $_SESSION["role"] = $role;   
    $_SESSION["staffid"] = $staffid;

    // Valid credentials
    echo "Login successful!";
    // Redirect based on role
    if ($role == "admin") {
        header("Location: Admin/admin_home.html");
    } elseif ($role == "student") {
        header("Location: Student/student.php");
    } elseif ($role == "teacher") {
        header("Location: Teacher/teacher_home.html");
    } else {
        // Handle unknown roles here
        echo '<script>alert("Error: Unknown role. Please contact support.");</script>';
    }



} else {
    // Invalid credentials
    echo '<script>alert("Error: Login failed. Please check your username, password, and role.");</script>';
    // print_r($_SESSION);
    // print_r($result);
}


$conn->close();
?>

