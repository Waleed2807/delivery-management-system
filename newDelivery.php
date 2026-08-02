<?php
// Include necessary model classes and files
require_once('Models/Database.php');
require_once('Models/DeliveryPoint.php');
require_once('Models/DeliveryPointDataset.php');

// Use relevant namespaces
use Models\Database;
use Models\DeliveryPointDataSet;

// Create an instance of the Database class
$db = Database::getInstance();

// Get the database connection
$connection = $db->getdbConnection();

// Check if the form for adding a new delivery point is submitted
if (isset($_POST["newDelivery"])) {
    // Get and sanitize input data from the POST request
    $name = isset($_POST["name"]) ? filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING) : null;
    $address_1 = isset($_POST["address_1"]) ? filter_input(INPUT_POST, 'address_1', FILTER_SANITIZE_STRING) : null;
    $address_2 = isset($_POST["address_2"]) ? filter_input(INPUT_POST, 'address_2', FILTER_SANITIZE_STRING) : null;
    $postcode = isset($_POST["postcode"]) ? filter_input(INPUT_POST, 'postcode', FILTER_SANITIZE_STRING) : null;

    // Set default values for other parameters
    $deliverer = 0;
    $lat = mt_rand(-90, 90);
    $lng = mt_rand(-180, 180);
    $status = 1;
    $del_photo = "";

    // Create an instance of the DeliveryPointDataSet class
    $deliveryPointDataSet = new DeliveryPointDataSet();

    // Insert a new delivery point into the database and check the result
    $result = $deliveryPointDataSet->insertNewDeliveryPoint($name, $address_1, $address_2, $postcode, $deliverer, $lat, $lng, $status, $del_photo);

    // Display success or error message based on the result
    if ($result) {
        echo "<style>#success{visibility: visible !important;}</style>";
    } else {
        echo "<style>#err{visibility: visible !important;}</style>";
    }
}
