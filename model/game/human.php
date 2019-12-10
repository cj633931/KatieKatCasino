<?php

class Human extends Player {
    
    private $decision = NULL;
    
    public function __construct($name, $money) {
        Player::__construct($name, $money, 'human');
    }
    
    public function decide($hand) {
        
    }
}