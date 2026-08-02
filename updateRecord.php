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

    // Check if 'id', 'name', 'address_1', 'address_2', and 'postcode' keys are set in the JSON data
    if (isset($postData['id'], $postData['name'], $postData['address_1'], $postData['address_2'], $postData['postcode'])) {
        // Extract 'id', 'name', 'address_1', 'address_2', and 'postcode' from the JSON data
        $id = $postData['id'];
        $name = $postData['name'];
        $address_1 = $postData['address_1'];
        $address_2 = $postData['address_2'];
        $postcode = $postData['postcode'];

        try {
            // Update the details of the specified delivery point in the database
            $result = $deliveryPointDataset->updateDeliveryPoint($id, $name, $address_1, $address_2, $postcode);

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
        // Display error message if 'id', 'name', 'address_1', 'address_2', or 'postcode' keys are missing in the JSON data
        echo '<style>#err{visibility: visible !important;}</style>';
    }
} else {
    // Display error message for requests that are not POST
    echo '<style>#err{visibility: visible !important;}</style>';
}
