<?php

// Include necessary files and classes
require_once('images/createImage.php');
require_once('Models/Database.php');
require_once('Models/DeliveryUsersDataset.php');

// Import relevant namespace
use Models\DeliveryUsersDataset;

// Create an instance of DeliveryUsersDataset
$usersDataset = new DeliveryUsersDataset();

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode JSON data from the request body
    $postData = json_decode(file_get_contents("php://input"), true);

    // Check if 'id' and 'status' keys are set in the JSON data
    if (isset($postData['id'], $postData['status'])) {
        // Extract 'id' and 'status' from the JSON data
        $id = $postData['id'];
        $status = $postData['status'];
        $del_photo = null;

        // If the status is 4, create a delivery photo using the create() function
        if ($status == 4) {
            $del_photo = create();
        }

        try {
            // Update the delivery status and photo in the database
            $result = $usersDataset->updateDelivery($id, $status, $del_photo);

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
        // Display error message if 'id' or 'status' keys are missing in the JSON data
        echo '<style>#err{visibility: visible !important;}</style>';
    }
} else {
    // Display error message for requests that are not POST
    echo '<style>#err{visibility: visible !important;}</style>';
}
