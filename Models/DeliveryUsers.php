<?php

namespace Models;

/**
 * Class DeliveryUsers
 *
 * Represents a user with user-related information.
 */
class DeliveryUsers
{
    protected $_userid, $_username, $_password, $_usertype;

    /**
     * Constructor for the DeliveryUsers class.
     *
     * Initializes the object with data from a database row.
     *
     * @param array $dbRow Database row containing user information.
     */
    public function __construct($dbRow) {
        $this->_userid = $dbRow['userid'];
        $this->_username = $dbRow['username'];
        $this->_password = $dbRow['password'];
        $this->_usertype = $dbRow['usertype'];
    }

    /**
     * Get the user ID.
     *
     * @return mixed The user ID.
     */
    public function getUserId() {
        return $this->_userid;
    }

    /**
     * Get the username.
     *
     * @return mixed The username.
     */
    public function getUsername() {
        return $this->_username;
    }

    /**
     * Get the user's password.
     *
     * @return mixed The user's password.
     */
    public function getPassword() {
        return $this->_password;
    }

    /**
     * Get the user type.
     *
     * @return mixed The user type.
     */
    public function getUserType() {
        return $this->_usertype;
    }
}
