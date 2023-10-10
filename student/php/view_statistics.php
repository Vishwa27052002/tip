<?php
session_start();
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Ensure the student is authenticated and retrieve their ID from the session
    if (!isset($_SESSION['student_id'])) {
        echo json_encode(['error' => 'Not authenticated']);
        exit();
    }

    // Fetch student-specific statistics from the database
    try {
        $studentId = $_SESSION['student_id'];

        // Modify this query to fetch the relevant statistics from your database
        $query = "SELECT * FROM student_statistics WHERE student_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$studentId]);
        $statisticsData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return statistics data as JSON
        header('Content-Type: application/json');
        echo json_encode($statisticsData);
    } catch (PDOException $e) {
        // Handle database error
        echo json_encode(['error' => 'Database error']);
    }
} else {
    // Handle unsupported HTTP methods
    echo json_encode(['error' => 'Unsupported method']);
}
?>
