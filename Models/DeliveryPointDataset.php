<?php

namespace Models;

require_once('DeliveryPoint.php');
/**
 * Class DeliveryPointDataSet
 *
 * Manages the retrieval, insertion, deletion, and updating of delivery point records in the database.
 */
class DeliveryPointDataSet {

    protected $_dbConnection, $_dbInstance;
    /**
     * Constructor for the DeliveryPointDataSet class.
     *
     * Initializes the database connection.
     */
    public function __construct() {
        $this->_dbInstance = Database::getInstance();
        $this->_dbConnection = $this->_dbInstance->getDbConnection();
    }
    /**
     * Fetches all delivery points from the database.
     *
     * @return array An array of DeliveryPoint objects.
     */
    public function fetchAll() {
        $sqlQuery = 'SELECT id, name, address_1, address_2, postcode, deliverer, lat, lng, del_photo FROM delivery_points ORDER BY id';

        $statement = $this->_dbConnection->prepare($sqlQuery); // prepare a PDO statement
        $statement->execute(); // execute the PDO statement

        $dataSet = [];
        while ($row = $statement->fetch()) {
            $dataSet[] = new DeliveryPoint($row);
        }
        return $dataSet;
    }
    /**
     * Inserts a new delivery point into the database.
     *
     * @param string $name      Delivery point name.
     * @param string $address_1 First address line.
     * @param string $address_2 Second address line.
     * @param string $postcode  Delivery point postcode.
     * @param int    $deliverer Deliverer ID.
     * @param string $lat       Latitude.
     * @param string $lng       Longitude.
     * @param int    $status    Delivery point status.
     * @param string $del_photo Delivery photo.
     * @return bool True if the insertion is successful, false otherwise.
     */
    public function insertNewDeliveryPoint($name, $address_1, $address_2, $postcode, $deliverer, $lat, $lng, $status, $del_photo) {
        $sql = "INSERT INTO delivery_point (name, address_1, address_2, postcode, deliverer, lat, lng, status, del_photo) 
            VALUES (:name, :address_1, :address_2, :postcode, :deliverer, :lat, :lng, :status, :del_photo)";

        $statement = $this->_dbConnection->prepare($sql);

        $statement->bindParam(':name', $name, \PDO::PARAM_STR);
        $statement->bindParam(':address_1', $address_1, \PDO::PARAM_STR);
        $statement->bindParam(':address_2', $address_2, \PDO::PARAM_STR);
        $statement->bindParam(':postcode', $postcode, \PDO::PARAM_STR);
        $statement->bindParam(':deliverer', $deliverer, \PDO::PARAM_INT);
        $statement->bindParam(':lat', $lat, \PDO::PARAM_STR);
        $statement->bindParam(':lng', $lng, \PDO::PARAM_STR);
        $statement->bindParam(':status', $status, \PDO::PARAM_INT);
        $statement->bindParam(':del_photo', $del_photo, \PDO::PARAM_STR);

        return $statement->execute();
    }
    /**
     * Deletes a delivery point from the database.
     *
     * @param int $id Delivery point ID.
     * @return bool True if the deletion is successful, false otherwise.
     */
    public function deleteDeliveryPoint($id) {
        $sql = "DELETE FROM delivery_point WHERE id = :id";
        $statement = $this->_dbConnection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);
        return $statement->execute();
    }
    /**
     * Retrieves a delivery point by its ID from the database.
     *
     * @param int $id Delivery point ID.
     * @return DeliveryPoint|null A DeliveryPoint object if found, null otherwise.
     */
    public function getDeliveryPointById($id) {
        $sql = "SELECT * FROM delivery_point WHERE id = :id";
        $statement = $this->_dbConnection->prepare($sql);
        $statement->bindParam(':id', $id, \PDO::PARAM_INT);

        if ($statement->execute()) {
            $data = $statement->fetch(\PDO::FETCH_ASSOC);
            if ($data) {
                return new DeliveryPoint($data);
            }
        }
        return null;
    }
    /**
     * Updates the deliverer of a delivery point in the database.
     *
     * @param int $id        Delivery point ID.
     * @param int $deliverer New deliverer ID.
     * @return bool True if the update is successful, false otherwise.
     */
    public function updateDeliverer($id, $deliverer) {
        $sql = "UPDATE delivery_point SET deliverer = :deliverer WHERE id = :id";
        $statement = $this->_dbConnection->prepare($sql);
        return $statement->execute([':deliverer' => $deliverer, ':id' => $id]);
    }
    /**
     * Updates the details of a delivery point in the database.
     *
     * @param int    $id        Delivery point ID.
     * @param string $name      New name.
     * @param string $address_1 New first address line.
     * @param string $address_2 New second address line.
     * @param string $postcode  New postcode.
     * @return bool True if the update is successful, false otherwise.
     */
    public function updateDeliveryPoint($id, $name, $address_1, $address_2, $postcode) {
        $sql = "UPDATE delivery_point SET name = :name, address_1 = :address_1, address_2 = :address_2, postcode = :postcode WHERE id = :id";
        $statement = $this->_dbConnection->prepare($sql);
        return $statement->execute([
            ':name' => $name,
            ':address_1' => $address_1,
            ':address_2' => $address_2,
            ':postcode' => $postcode,
            ':id' => $id
        ]);
    }
    /**
     * Fetches delivery points from the database based on search, filter, offset, and records per page.
     *
     * @param string $searchTerm     Search term to filter delivery points.
     * @param string $filter         Sorting filter.
     * @param int    $offset         Offset for pagination.
     * @param int    $recordsPerPage Number of records per page.
     * @return array An array of DeliveryPoint objects.
     */
    public function fetchDeliveryPoints($searchTerm = '', $filter = '', $offset = 0, $recordsPerPage = 10) {
        // Implementation of fetchDeliveryPoints method
        $whereClauses = [];
        $params = [];

        if (!empty($searchTerm)) {
            $whereClauses[] = "(name LIKE :searchTerm OR address_1 LIKE :searchTerm OR address_2 LIKE :searchTerm OR postcode LIKE :searchTerm)";
            $params[':searchTerm'] = '%' . $searchTerm . '%';
        }
        $orderBy = " ORDER BY id DESC";

        if ($filter) {
            switch ($filter) {
                case 'Oldest':
                    $orderBy = " ORDER BY id ASC";
                    break;
                case 'Name':
                    $orderBy = " ORDER BY name ASC";
                    break;
                case 'Delivered':
                    $whereClauses[] = "status = 4";
                    break;
                case 'Not Delivered':
                    $whereClauses[] = "status NOT IN (4)";
                    break;
                default:
                    $orderBy = " ORDER BY id DESC";
                    break;
            }
        }

        $whereSql = $whereClauses ? ' WHERE ' . implode(' AND ', $whereClauses) : '';
        $sql = "SELECT * FROM delivery_point" . $whereSql . $orderBy . " LIMIT :offset, :recordsPerPage";

        $statement = $this->_dbConnection->prepare($sql);
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $statement->bindValue(':recordsPerPage', $recordsPerPage, \PDO::PARAM_INT);

        $statement->execute();
        $results = [];
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $results[] = new DeliveryPoint($row);
        }
        return $results;
    }
    /**
     * Gets the total number of records based on search and filter criteria.
     *
     * @param string $searchTerm Search term to filter delivery points.
     * @param string $filter     Sorting filter.
     * @return int The total number of records.
     */

    public function getTotalRecords($searchTerm = '', $filter = '') {
        $whereClauses = [];
        $params = [];

        if (!empty($searchTerm)) {
            $whereClauses[] = "(name LIKE :searchTerm OR address_1 LIKE :searchTerm OR address_2 LIKE :searchTerm OR postcode LIKE :searchTerm)";
            $params[':searchTerm'] = '%' . $searchTerm . '%';
        }

        if ($filter) {
            switch ($filter) {
                case 'Oldest':
                    break;
                case 'Name':
                    break;
                case 'Latest':
                    break;
                case 'Delivered':
                    $whereClauses[] = "status = 4";
                    break;
                case 'Not Delivered':
                    $whereClauses[] = "status NOT IN (4)";
                    break;
            }
        }

        $whereSql = $whereClauses ? ' WHERE ' . implode(' AND ', $whereClauses) : '';
        $sql = "SELECT COUNT(*) AS total FROM delivery_point" . $whereSql;

        $statement = $this->_dbConnection->prepare($sql);
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }

        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }
    /**
     * Gets the total number of records for a specific user based on search and filter criteria.
     *
     * @param int    $userId     User ID for filtering delivery points.
     * @param string $searchTerm Search term to filter delivery points.
     * @param string $filter     Sorting filter.
     * @return int The total number of records for the user.
     */
    public function getTotalRecordsForUser($userId, $searchTerm = '', $filter = '') {
        $whereClauses = ["deliverer = :userId"];
        $params = [':userId' => $userId];

        if (!empty($searchTerm)) {
            $whereClauses[] = "(name LIKE :searchTerm OR address_1 LIKE :searchTerm OR address_2 LIKE :searchTerm OR postcode LIKE :searchTerm)";
            $params[':searchTerm'] = '%' . $searchTerm . '%';
        }

        if ($filter) {
            switch ($filter) {
                case 'Oldest':
                    break;
                case 'Name':
                    break;
                case 'Latest':
                    break;
                case 'Delivered':
                    $whereClauses[] = "status = 4";
                    break;
                case 'Not Delivered':
                    $whereClauses[] = "status NOT IN (4)";
                    break;
            }
        }

        $whereSql = $whereClauses ? ' WHERE ' . implode(' AND ', $whereClauses) : '';
        $sql = "SELECT COUNT(*) AS total FROM delivery_point" . $whereSql;

        $statement = $this->_dbConnection->prepare($sql);
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }

        $statement->execute();
        $result = $statement->fetch(\PDO::FETCH_ASSOC);
        return (int)$result['total'];
    }

    public function fetchDeliveryPointsForUser($userId, $searchTerm = '', $filter = '', $offset = 0, $recordsPerPage = 10) {
        $whereClauses = ["deliverer = :userId"];
        $params = [':userId' => $userId];

        if (!empty($searchTerm)) {
            $whereClauses[] = "(name LIKE :searchTerm OR address_1 LIKE :searchTerm OR address_2 LIKE :searchTerm OR postcode LIKE :searchTerm)";
            $params[':searchTerm'] = '%' . $searchTerm . '%';
        }

        $orderBy = " ORDER BY id DESC";
        if ($filter) {
            switch ($filter) {
                case 'Oldest':
                    $orderBy = " ORDER BY id ASC";
                    break;
                case 'Name':
                    $orderBy = " ORDER BY name ASC";
                    break;
                case 'Delivered':
                    $whereClauses[] = "status = 4";
                    break;
                case 'Not Delivered':
                    $whereClauses[] = "status NOT IN (4)";
                    break;
                default:
                    $orderBy = " ORDER BY id DESC";
                    break;
            }
        }

        $whereSql = $whereClauses ? ' WHERE ' . implode(' AND ', $whereClauses) : '';
        $sql = "SELECT * FROM delivery_point" . $whereSql . $orderBy . " LIMIT :offset, :recordsPerPage";

        $statement = $this->_dbConnection->prepare($sql);
        foreach ($params as $key => $value) {
            $statement->bindValue($key, $value);
        }
        $statement->bindValue(':offset', $offset, \PDO::PARAM_INT);
        $statement->bindValue(':recordsPerPage', $recordsPerPage, \PDO::PARAM_INT);

        $statement->execute();
        $results = [];
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            $results[] = new DeliveryPoint($row);
        }
        return $results;
    }

}