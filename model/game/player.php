<?php

class Player {
    
    private $name;
    private $money;
    private $hands;
    private $game;
    
    public function __construct($name, $money) {
        $this->name = $name;
        $this->money = $money;
    }
    
    public function joinGame($game) {
        if (!isset($this->game)) {
            $this->game = $game;
        } else {
            throw new Exception('Player cannot join a new game before leaving previous game.');
        }
    }
    
    public function leaveGame() {
        $this->game = NULL;
    }
    
    public function bet($amount = NULL) {
        if (!isset($this->game)) {
            throw new Exception('Player cannot bet if they are not part of a game.');
        } else {
            if (!isset($amount)) {
                $amount = $this->game->getMinimumBet();
            }
            $this->hands = array();
            $this->ponyUp($amount);
            $newHand = new Hand($amount);
            $firstCard = $this->game->getDealer()->deal();
            $newHand->hit($firstCard);
            $secondCard = $this->game->getDealer()->deal();
            $newHand->hit($secondCard);
            array_push($this->hands, $newHand);
        }
    }
    
    private function pony_up($amount) {
        if ($this->money >= $amount) {
            $this->money -= $amount;
            $this->game->getDealer()->rakeIn($amount);
        } else {
            throw new Exception('Player cannot bet more than they have.');
        }
    }
    
    private function rake_in($amount) {
        $this->money += $amount;
    }
    
//    public function play() {
//        
//    }
//    STILL NEEDS TO BE IMPLEMENTED.
}