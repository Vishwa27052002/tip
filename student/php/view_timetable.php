<?php
session_start();
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch the timetable data from the database
    try {
        $query = "SELECT * FROM sessions";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $timetableData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the timetable data as JSON
        header('Content-Type: application/json');
        echo json_encode($timetableData);
    } catch (PDOException $e) {
        // Handle database error
        echo json_encode(['error' => 'Database error']);
    }
} else {
    // Handle unsupported HTTP methods
    echo json_encode(['error' => 'Unsupported method']);
}
?>
