<?php

class Card {
    
    private $suits = array('clubs', 'spades', 'hearts', 'diamonds');
    private $unicode = array('\u2663','\u2660','\u2665','\u2666');
    private $names = array('ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'jack', 'queen', 'king');
    private $hardValues = array(1,2,3,4,5,6,7,8,9,10,10,10,10);
    private $softValues = array(11,2,3,4,5,6,7,8,9,10,10,10,10);
    
    
    function __construct($name, $suit) {
        // If the name is a valid one, assign it.
        if (in_array($name, $this->names)) {
            $this->name = $name;
        }
        
        $this->suit = $suit;
    }
}