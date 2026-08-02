<?php
// Set up error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Include necessary model classes and files
require_once('Models/Database.php');
require_once('newDelivery.php');
require_once('logincontroller.php');
require_once('Models/DeliveryPointDataset.php');
require_once('Models/DeliveryUsersDataset.php');


// Use relevant namespaces
use Models\DeliveryPointDataset;
use Models\DeliveryUsersDataset;

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit;
}

// Check if the user type is not admin, redirect to the appropriate page
if ($_SESSION['type'] != 1) {
    header('Location: page2.php');
    exit;
}

// Create instances of the necessary datasets
$deliveryPointDataset = new DeliveryPointDataset();
$usersDataset = new DeliveryUsersDataset();

// Fetch all usernames for display
$usernames = $usersDataset->fetchAllUsernames();

// Get search term and filter from the POST request
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
$filter = isset($_POST['filter']) ? $_POST['filter'] : '';

// Pagination setup
$recordsPerPage = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $recordsPerPage;

// Fetch delivery points based on search, filter, and pagination parameters
$deliveryPoints = $deliveryPointDataset->fetchDeliveryPoints($searchTerm, $filter, $offset, $recordsPerPage);

// Get total records for pagination
$totalRecords = $deliveryPointDataset->getTotalRecords($searchTerm, $filter);
$totalPages = ceil($totalRecords / $recordsPerPage);

// Set up the view object
$view = new stdClass();
$view->pageTitle = 'Page1';

// Include the appropriate view file
require_once('Views/page1.phtml');

// Assign the logged-in username to the view
$view->username = $_SESSION['login'];
