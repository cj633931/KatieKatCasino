<?php

class Profile {

    private $firstName;
    private $lastName;
    private $username;
    private $password;

    function __construct($firstName = "", $lastName = "", $username = "", $password = "") {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->password = $password;
    }

    function getFirstName() {
        return $this->firstName;
    }
    
    function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
    
    function getLastName() {
        return $this->lastName;
    }
    
    function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    
    function getUsername() {
        return $this->username;
    }
    
    function setUsername($username) {
        $this->username = $username;
    }
}