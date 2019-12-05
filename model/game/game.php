<?php

class Game {
    
    private $dealer;
    private $players = array();
    private $minimumBet;
    private $maximumBet;
    private $deckCount;
    private $maxPlayers;


    // The most popular casino blacjack is played with 6 decks and 7 players max.
    public function __construct($minimumBet, $maximumBet, $deckCount=6, $maxPlayers=7) {
        $this->dealer = new Dealer();
        $this->minimumBet = $minimumBet;
        $this->maximumBet = $maximumBet;
        $this->deckCount = $deckCount;
        $this->maxPlayers = $maxPlayers;
    }
    
}