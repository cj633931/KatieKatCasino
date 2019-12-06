<?php

class Human extends Player {
    
    private $decision = NULL;
    
    public function __construct($name, $money, $initialBet) {
        Player::__construct($name, $money, $initialBet, 'human');
    }
    
    public function decide($hand) {
        
    }
}