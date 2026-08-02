<?php

// Include necessary model classes and files
require_once('Models/Database.php');
require_once('logincontroller.php');
require_once('Models/DeliveryPointDataset.php');
require_once('Models/DeliveryUsersDataset.php');

// Use relevant namespaces
use Models\DeliveryPointDataset;
use Models\DeliveryUsersDataset;

// Create instances of the necessary datasets
$deliveryPointDataset = new DeliveryPointDataset();
$usersDataset = new DeliveryUsersDataset();

// Check if the user is not logged in, redirect to the login page
if (!isset($_SESSION['login'])) {
    header('Location: index.php');
    exit;
}

// Check if the user type is not a deliverer, redirect to the appropriate page
if ($_SESSION['type'] != 2) {
    header('Location: page1.php');
    exit;
}

// Fetch all usernames for display
$usernames = $usersDataset->fetchAllUsernames();

// Get logged-in user information
$loggedInUsername = $_SESSION['login'];
$loggedInUserId = $usersDataset->getUserIdByUsername($loggedInUsername);

// Get search term and filter from the POST request
$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';
$filter = isset($_POST['filter']) ? $_POST['filter'] : '';

// Pagination setup
$recordsPerPage = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $recordsPerPage;

// Fetch delivery points for the logged-in user based on search, filter, and pagination parameters
$deliveryPoints = $deliveryPointDataset->fetchDeliveryPointsForUser($loggedInUserId, $searchTerm, $filter, $offset, $recordsPerPage);

// Get total records for pagination
$totalRecords = $deliveryPointDataset->getTotalRecordsForUser($loggedInUserId, $searchTerm, $filter);
$totalPages = ceil($totalRecords / $recordsPerPage);

// Set up the view object
$view = new stdClass();
$view->pageTitle = 'Page2';

// Include the appropriate view file
require_once('Views/page2.phtml');

// Assign the logged-in username to the view
$view->username = $_SESSION['login'];
