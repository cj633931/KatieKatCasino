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
        $this->maxPlayers += 1; // Add an extra for the dealer.
        $this->dealer->joinGame($this);
    }
    
    private function getPlayerCount() {
        return count($this->players);
    }
    
    private function getPlayers() {
        return $this->players;
    }
    
    public function addPlayer($player) {
        if ($this->getPlayerCount() === $this->maxPlayers) {
            throw new Exception($player->getName() . ' cannot fit at this table.');
        }
    }
    
    public function removePlayer($player) {
        $result = array_search($player, $this->players);
        if (!$result) {
            throw new Exception($player->getName() . ' could not be found at this game.');
        } else {
            array_splice($this->players, $result, 1);
        }
    }
    
    public function play() {
        while ($this->getPlayerCount() > 0) {
            // If the dealer needs to shuffle, he should do it now.
            if ($this->dealer->shouldShuffle($this->getPlayerCount())) {
                $this->dealer->shuffle();
            }
            foreach ($this->players as $player) {
                $player->bet();
            }
            foreach ($this->players as $player) {
                $player->play();
            }
        }
    }
}