<?php
session_start();

$materialDirectory = 'learning_materials';

// Ensure the student is authenticated (you can use the same authentication check as in previous examples)
if (!isset($_SESSION['student_id'])) {
    echo json_encode(['error' => 'Not authenticated']);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $material = isset($_GET['material']) ? $_GET['material'] : '';

    if (empty($material)) {
        // List available materials
        $materials = scandir($materialDirectory);
        $materials = array_diff($materials, ['.', '..']); // Remove "." and ".." from the list

        header('Content-Type: application/json');
        echo json_encode($materials);
    } else {
        // Serve the requested material
        $materialPath = $materialDirectory . '/' . $material;

        if (file_exists($materialPath)) {
            // Set the appropriate headers for downloading files
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $material . '"');
            readfile($materialPath);
        } else {
            echo json_encode(['error' => 'Material not found']);
        }
    }
} else {
    // Handle unsupported HTTP methods
    echo json_encode(['error' => 'Unsupported method']);
}
?>
