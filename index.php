<?php

// Load local DB credentials (gitignored) if present — see config.example.php
if (file_exists(__DIR__ . '/config.php')) {
    require_once(__DIR__ . '/config.php');
}

// Create a new stdClass instance for the view
$view = new stdClass();

// Set the page title for the view
$view->pageTitle = 'Homepage';

// Include the login controller
require_once("logincontroller.php");

// Include the HTML view file ('index.phtml')
require_once('Views/index.phtml');
