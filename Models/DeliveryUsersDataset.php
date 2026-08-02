<?php

namespace Models;

/**
 * Class DeliveryUsersDataset
 *
 * Manages the retrieval and manipulation of delivery user records in the database.
 */
class DeliveryUsersDataset
{

    protected $_dbConnection, $_dbInstance;

    /**
     * Constructor for the DeliveryUsersDataset class.
     *
     * Initializes the database connection.
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbConnection = $this->_dbInstance->getDbConnection();
    }

    /**
     * Fetches all delivery users from the database.
     *
     * @return array An array of DeliveryUsers objects.
     */
    public function fetchAll() {
        $sqlQuery = 'SELECT userid, username, password, usertype FROM delivery_users ORDER BY userid';

        $statement = $this->_dbConnection->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryUsers($row);
        }
        return $dataSet;
    }

    /**
     * Fetches all usernames and their corresponding user IDs from the database.
     *
     * @return array An associative array of user IDs and usernames.
     */
    public function fetchAllUsernames() {
        $usernames = [];
        $query = "SELECT userid, username FROM delivery_users";

        $statement = $this->_dbConnection->prepare($query);
        $statement->execute();

        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $usernames[$row['userid']] = $row['username'];
        }

        return $usernames;
    }

    /**
     * Fetches user data based on the provided username.
     *
     * @param string $username The username to search for.
     * @return array|null An associative array of user data if found, null otherwise.
     */
    public function fetchUserByUsername($username) {
        $sqlQuery = "SELECT * FROM delivery_users WHERE username = :username LIMIT 1";
        $statement = $this->_dbConnection->prepare($sqlQuery);
        $statement->execute([':username' => $username]);
        return $statement->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Updates the delivery status and delivery photo of a delivery point in the database.
     *
     * @param int    $id        Delivery point ID.
     * @param int    $status    New delivery status.
     * @param string $del_photo New delivery photo.
     * @return bool True if the update is successful, false otherwise.
     */
    public function updateDelivery($id, $status, $del_photo) {
        if ($del_photo !== null) {
            $query = "UPDATE delivery_point SET status = :status, del_photo = :del_photo WHERE id = :id";
            $data = [':status' => $status, ':del_photo' => $del_photo, ':id' => $id];
        } else {
            $query = "UPDATE delivery_point SET status = :status WHERE id = :id";
            $data = [':status' => $status, ':id' => $id];
        }

        $statement = $this->_dbConnection->prepare($query);
        return $statement->execute($data);
    }

    /**
     * Retrieves the user ID associated with the provided username.
     *
     * @param string $username The username to search for.
     * @return int|null The user ID if found, null otherwise.
     */
    public function getUserIdByUsername($username) {
        $sqlQuery = "SELECT userid FROM delivery_users WHERE username = :username";
        $statement = $this->_dbConnection->prepare($sqlQuery);
        $statement->execute([':username' => $username]);

        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result['userid'] : null;
    }
}
