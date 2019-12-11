<?php

class Game {

    private $dealer;
    private $player;
    private $minimumBet;
    private $maximumBet;
    private $deckCount;

    // The most popular casino blacjack is played with 6 decks and 7 players max.
    public function __construct($minimumBet, $maximumBet, $deckCount = 6) {
        $this->minimumBet = $minimumBet;
        $this->maximumBet = $maximumBet;
        $this->deckCount = $deckCount;
        try {
            $this->dealer = new Dealer();
            $this->dealer->joinGame($this);
        } catch (Exception $dealerException) {
            throw new Exception('Could not create and add dealer to game: ' . $dealerException);
        }
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
        return $this->player->getName() . ": " . $this->player->getHand()->getValue() . "\n" . $this->player->getHand() . "\n";
    }

    public function getDealerHand($showValue=FALSE) {
        if ($showValue) {
            return $this->dealer->getName() . ": " . $this->dealer->getHand()->getValue() . "\n" . $this->dealer->getHand() . "\n";        
        } else {
            return $this->dealer->getName() . ": \n" . $this->dealer->getHand() . "\n";            
        }
    }

}
