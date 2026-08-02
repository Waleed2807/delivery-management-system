<?php
// Include necessary files
require_once('Models/Database.php');
require_once('Models/DeliveryPointDataset.php');
// Use relevant namespaces

use Models\Database;
use Models\DeliveryPointDataSet;
// Get a database instance

$db = Database::getInstance();
// Create an instance of DeliveryPointDataSet

$deliveryPointDataSet = new DeliveryPointDataSet();
// Check if 'id' is set in the GET parameters and is numeric

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];
    // Attempt to delete the delivery point with the specified ID

    if ($deliveryPointDataSet->deleteDeliveryPoint($id)) {
        // Redirect to 'page1.php' upon successful deletion

        header('Location: page1.php');
        exit;
    } else {
        // Redirect to 'page1.php' if deletion is unsuccessful

        header('Location: page1.php');
        exit;
    }
}
