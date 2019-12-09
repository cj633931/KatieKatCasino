<?php

class Profile {

    private $firstName;
    private $lastName;
    private $username;
    private $money;

    public function __construct($firstName='', $lastName='', $username='', $money=1000) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->username = $username;
        $this->money = $money;
    }

    public function getFirstName() {
        return $this->firstName;
    }
    
    public function setFirstName($firstName) {
        $this->firstName = $firstName;
    }
    
    public function getLastName() {
        return $this->lastName;
    }
    
    public function setLastName($lastName) {
        $this->lastName = $lastName;
    }
    
    public function getUsername() {
        return $this->username;
    }
    
    public function setUsername($username) {
        $this->username = $username;
    }
    
    public function getMoney() {
        return $this->money;
    }
    
    public function setMoney($username) {
        $this->username = $username;
    }
}
