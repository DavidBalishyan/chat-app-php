<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Redirect to the chat page if logged in
    header('Location: chat.php');
    exit;
} else {
    // Redirect to the login page if not logged in
    header('Location: registration.php');
    exit;
}
