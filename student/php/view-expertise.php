<?php
session_start();
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch tutor expertise data from the database
    try {
        $query = "SELECT * FROM tutor_expertise";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $expertiseData = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return tutor expertise data as JSON
        header('Content-Type: application/json');
        echo json_encode($expertiseData);
    } catch (PDOException $e) {
        // Handle database error
        echo json_encode(['error' => 'Database error']);
    }
} else {
    // Handle unsupported HTTP methods
    echo json_encode(['error' => 'Unsupported method']);
}
?>
