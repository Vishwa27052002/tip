<?php
session_start();

// Destroy the session and log the student out
session_destroy();

// Redirect the student to the login page or any other desired page
header('Location: ../index.html');
exit();
?>
