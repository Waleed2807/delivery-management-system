<?php

require_once('Models/Database.php');
require_once('Models/DeliveryPointDataset.php');

use Models\Database;
use Models\DeliveryPointDataSet;

$db = Database::getInstance();
$deliveryPointDataSet = new DeliveryPointDataSet();

if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];
    $deliveryPoint = $deliveryPointDataSet->getDeliveryPointById($id);

    if ($deliveryPoint) {
        $recordData = [
            'id' => $deliveryPoint->getId(),
            'name' => $deliveryPoint->getName(),
            'address_1' => $deliveryPoint->getAddress1(),
            'address_2' => $deliveryPoint->getAddress2(),
            'postcode' => $deliveryPoint->getPostcode()
        ];
        echo json_encode($recordData);
    } else {
        echo json_encode(array("error" => "not found"));
    }
} else {
    echo json_encode(array("error" => "invalid id"));
}

?>