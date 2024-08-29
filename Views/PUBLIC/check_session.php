<?php
session_start();

$response = array('session_active' => false);

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['session_token'])) {
    $response['session_active'] = true;
}

header('Content-Type: application/json');
echo json_encode($response);
?>
