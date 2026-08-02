<?php

namespace Models;

use PDO;
use PDOException;

// Load local DB credentials (gitignored) if present — see config.example.php
// in the project root. Doing this here means every entry point that touches
// Database::getInstance() picks up the credentials automatically.
$__configPath = __DIR__ . '/../config.php';
if (file_exists($__configPath)) {
    require_once($__configPath);
}

/**
 * Class Database
 *
 * Manages a connection to the database using PDO.
 */
class Database
{
    /**
     * @var Database
     */
    protected static $_dbInstance = null;

    /**
     * @var PDO
     */
    protected $_dbHandle;

    /**
     * Retrieves an instance of the Database class.
     *
     * @return Database
     */
    public static function getInstance()
    {
        // Database connection parameters — loaded from environment variables.
        // Set these in your server config or a local (gitignored) config.php that
        // defines them before this file runs. Never commit real credentials.
        $username = getenv('DB_USERNAME') ?: 'db_user';
        $password = getenv('DB_PASSWORD') ?: 'db_password';
        $host = getenv('DB_HOST') ?: 'localhost';
        $dbName = getenv('DB_NAME') ?: 'delivery_system';

        // Create a new instance if not exists
        if (self::$_dbInstance === null) {
            try {
                self::$_dbInstance = new self($username, $password, $host, $dbName);
            } catch (PDOException $e) {
                // Handle connection error
                echo 'Database connection failed: ' . $e->getMessage();
            }
        }

        return self::$_dbInstance;
    }

    /**
     * Constructs a Database instance.
     *
     * @param string $username Database username.
     * @param string $password Database password.
     * @param string $host     Database host.
     * @param string $database Database name.
     * @throws PDOException If a PDO exception occurs during connection.
     */
    private function __construct($username, $password, $host, $database)
    {
        try {
            // Establish a PDO database connection
            $this->_dbHandle = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            $this->_dbHandle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Throw the exception if connection fails
            throw $e;
        }
    }

    /**
     * Retrieves the PDO database connection handle.
     *
     * @return PDO
     */
    public function getdbConnection()
    {
        return $this->_dbHandle;
    }

    /**
     * Destructs the Database instance.
     *
     * Closes the database connection when the object is destroyed.
     */
    public function __destruct()
    {
        $this->_dbHandle = null;
    }
}
