<?php

class Human extends Player {
    
    public function __construct($name, $money) {
        Player::__construct($name, $money, 'human');
    }
    
    // This class doesn't really serve a purpose besides the fact that it's here to
    // show that there is a difference between a human and a computer (mostly the dealer).
}