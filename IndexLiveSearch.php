<?php
require_once('loginController.php');
require_once('Models/DeliveryUsersDataSet.php');

// Start the session
session_start();

// Check if the user ID is set in the session
if (!isset($_SESSION['id'])) {
    echo json_encode(['error' => 'User ID not found in session.']);
    exit;
}

// Sanitize the user ID
$id = filter_var($_SESSION['id'], FILTER_SANITIZE_NUMBER_INT);

// Check if the 'q' parameter is set
if (!isset($_GET['q'])) {
    echo json_encode(['error' => 'Query parameter is missing.']);
    exit;
}

// Sanitize the 'q' parameter to prevent security vulnerabilities
$q = filter_var($_GET['q'], FILTER_SANITIZE_STRING);

// Create an instance of the dataset
$liveSearch = new \Models\DeliveryUsersDataset();

// Fetch data based on the sanitized input
$data = $liveSearch->fetchDeliveryUsersDataset($id, $q);

// Encode the data into JSON and return it
$jsonData = json_encode($data);
echo $jsonData;
