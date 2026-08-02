<?php

namespace Models;

/**
 * Class DeliveryPoint
 *
 * Represents a delivery point with various attributes.
 */
class DeliveryPoint
{
    protected $_id, $_name, $_address1, $_address2, $_postcode, $_deliverer, $_lat, $_lng, $_status, $_delPhoto;

    /**
     * Constructor for the DeliveryPoint class.
     *
     * Initializes the object with data from a database row.
     *
     * @param array $dbRow Database row containing delivery point information.
     */
    public function __construct($dbRow) {
        $this->_id = $dbRow['id'];
        $this->_name = $dbRow['name'];
        $this->_address1 = $dbRow['address_1'];
        $this->_address2 = $dbRow['address_2'];
        $this->_postcode = $dbRow['postcode'];
        $this->_deliverer = $dbRow['deliverer'];
        $this->_lat = $dbRow['lat'];
        $this->_lng = $dbRow['lng'];
        $this->_delPhoto = $dbRow['del_photo'];
        $this->_status = $dbRow['status'];
    }

    /**
     * Get the ID of the delivery point.
     *
     * @return mixed The ID of the delivery point.
     */
    public function getId() {
        return $this->_id;
    }

    /**
     * Get the name of the delivery point.
     *
     * @return mixed The name of the delivery point.
     */
    public function getName() {
        return $this->_name;
    }

    /**
     * Get the first address line of the delivery point.
     *
     * @return mixed The first address line.
     */
    public function getAddress1() {
        return $this->_address1;
    }

    /**
     * Get the second address line of the delivery point.
     *
     * @return mixed The second address line.
     */
    public function getAddress2() {
        return $this->_address2;
    }

    /**
     * Get the postcode of the delivery point.
     *
     * @return mixed The postcode of the delivery point.
     */
    public function getPostcode() {
        return $this->_postcode;
    }

    /**
     * Get the deliverer associated with the delivery point.
     *
     * @return mixed The deliverer of the delivery point.
     */
    public function getDeliverer() {
        return $this->_deliverer;
    }

    /**
     * Get the latitude of the delivery point.
     *
     * @return mixed The latitude of the delivery point.
     */
    public function getLat() {
        return $this->_lat;
    }

    /**
     * Get the longitude of the delivery point.
     *
     * @return mixed The longitude of the delivery point.
     */
    public function getLng() {
        return $this->_lng;
    }

    /**
     * Get the delivery photo of the delivery point.
     *
     * @return mixed The delivery photo of the delivery point.
     */
    public function getDelPhoto() {
        return $this->_delPhoto;
    }

    /**
     * Get the status of the delivery point.
     *
     * @return mixed The status of the delivery point.
     */
    public function getStatus() {
        return $this->_status;
    }
}
