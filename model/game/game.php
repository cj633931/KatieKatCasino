<?php

class Game {
    
    private $dealer;
    private $players;
    
    public function __construct($deckCount=6, $maxPlayers=6) {
        $this->dealer = new Dealer();
        $this->players = array();
        
    }
    
}