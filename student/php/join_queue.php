<?php
session_start();
include('db_config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the student is authenticated and retrieve their ID from the session
    if (!isset($_SESSION['student_id'])) {
        echo json_encode(['error' => 'Not authenticated']);
        exit();
    }

    // Assuming you have a current session ID stored in the session
    if (!isset($_SESSION['current_session_id'])) {
        echo json_encode(['error' => 'No session available']);
        exit();
    }

    // Insert the student into the session queue in the database
    try {
        $studentId = $_SESSION['student_id'];
        $sessionId = $_SESSION['current_session_id'];

        // Check if the student is not already in the queue for this session
        $query = "SELECT * FROM session_queue WHERE session_id = ? AND student_id = ?";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$sessionId, $studentId]);
        $existingQueueEntry = $stmt->fetch();

        if ($existingQueueEntry) {
            echo json_encode(['error' => 'You are already in the queue for this session.']);
        } else {
            // Insert the student into the queue
            $query = "INSERT INTO session_queue (session_id, student_id) VALUES (?, ?)";
            $stmt = $pdo->prepare($query);
            $stmt->execute([$sessionId, $studentId]);

            echo json_encode(['message' => 'You have joined the queue.']);
        }
    } catch (PDOException $e) {
        // Handle database error
        echo json_encode(['error' => 'Database error']);
    }
} else {
    // Handle unsupported HTTP methods
    echo json_encode(['error' => 'Unsupported method']);
}
?>
