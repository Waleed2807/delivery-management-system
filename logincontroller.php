<?php
// Start the session

session_start();
// Include necessary model classes and files

require_once('Models/Database.php');
require_once('Models/DeliveryUsers.php');
require_once('Models/DeliveryUsersDataset.php');
// Use relevant namespaces

use Models\DeliveryUsers;
use Models\DeliveryUsersDataset;
// Create an instance of the DeliveryUsersDataset class

$usersDataset = new DeliveryUsersDataset();
// Function to display an error message

function error() {
    echo '<style>#err{visibility: visible !important;}</style>';
}
// Check if the login button is pressed

if (isset($_POST["loginbutton"])) {
    // Get the username and password from the POST data

    $username = $_POST["username"];
    $password = $_POST["password"];
    // Check if either username or password is empty

    if (empty($username) || empty($password)) {
        error();
    } else {
        // Fetch user data from the database based on the username

        $userRow = $usersDataset->fetchUserByUsername($username);
        // If a user with the provided username is found

        if ($userRow) {
            // Create a DeliveryUsers object

            $user = new DeliveryUsers($userRow);
            // Verify the provided password against the stored hash

            if (password_verify($password, $user->getPassword())) {
                // Set session variables for login and user type

                $_SESSION["login"] = $user->getUsername();
                $_SESSION["type"] = $user->getUserType();
                // Redirect based on user type after a short delay

                if ($user->getUserType() === 1) {
                    sleep(2);
                    // Default redirect for unrecognized user type

                    header("location: page1.php");
                    exit;
                } else if ($user->getUserType() === 2) {
                    sleep(2);
                    header("location: page2.php");
                    exit;
                }
                header("location: page1.php");
                exit;
            } else {
                // Display error if password verification fails

                error();
            }
        } else {
            // Display error if user with the provided username is not found

            error();
        }
    }
}
// Check if the logout button is pressed

if (isset($_POST["logoutbutton"])) {
    // Unset login session variable and redirect to the home page

    unset($_SESSION["login"]);
    header("location: index.php");
    session_destroy();
}