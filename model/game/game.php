<?php

class Game {
    
    private $dealer;
    private $player;
    private $minimumBet;
    private $maximumBet;
    private $deckCount;


    // The most popular casino blacjack is played with 6 decks and 7 players max.
    public function __construct($minimumBet, $maximumBet, $deckCount=6) {
        $this->minimumBet = $minimumBet;
        $this->maximumBet = $maximumBet;
        $this->deckCount = $deckCount;
        $this->dealer = new Dealer();
        $this->dealer->joinGame($this);
    }
    
    public function addPlayer($player) {
        $this->player = $player;
    }
    
    public function getDealer() {
        return $this->dealer;
    }
    
    public function getPlayer() {
        return $this->player;
    }
    
    public function getPlayerHand() {
        return $this->player->getName() .": ". $this->player->getHandString() ."\n";
    }
    
    public function getDealerHand() {
        return $this->dealer->getName() .": ". $this->dealer->getHandString() ."\n";
    }
}