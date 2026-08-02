<?php

// Include necessary files and classes
require_once('Models/Database.php');
require_once('Models/DeliveryPointDataset.php');

// Import relevant namespace
use Models\Database;
use Models\DeliveryPointDataset;

// Create an instance of Database and DeliveryPointDataset
$db = Database::getInstance();
$deliveryPointDataset = new DeliveryPointDataset();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data from the request body
    $postData = json_decode(file_get_contents("php://input"), true);

    // Check if 'id' and 'deliverer' keys are set in the JSON data
    if (isset($postData['id'], $postData['deliverer'])) {
        // Extract 'id' and 'deliverer' from the JSON data
        $id = $postData['id'];
        $deliverer = $postData['deliverer'];

        try {
            // Update the deliverer for the specified delivery point in the database
            $result = $deliveryPointDataset->updateDeliverer($id, $deliverer);

            // Display success message if the update is successful
            if ($result) {
                echo "<style>#success{visibility: visible !important;}</style>";
            } else {
                // Display error message if the update fails
                echo '<style>#err{visibility: visible !important;}</style>';
            }
        } catch (PDOException $error) {
            // Display error message for any database-related errors
            echo '<style>#err{visibility: visible !important;}</style>';
        }
    } else {
        // Display error message if 'id' or 'deliverer' keys are missing in the JSON data
        echo '<style>#err{visibility: visible !important;}</style>';
    }
} else {
    // Display error message for requests that are not POST
    echo '<style>#err{visibility: visible !important;}</style>';
}

// Unset the database connection to free resources
unset($connection);
