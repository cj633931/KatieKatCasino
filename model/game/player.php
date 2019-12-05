<?php

class Player {
    
    private $name;
    private $money;
    private $hands = array();
    private $game = NULL; // if a game is NULL that means they haven't joined one yet.
    
    public function __construct($name, $money, $initialBet=1, $type='human') {
        $this->name = $name;
        $this->money = $money;
    }
    
    // Join a game only if the player isn't in one
    public function joinGame($game) {
        if (!isset($this->game)) {
            $this->game = $game;
        } else {
            throw new Exception('Player cannot join a new game before leaving previous game.');
        }
    }
    
    // Leave whatever game the player was at.
    public function leaveGame() {
        $this->game = NULL;
    }
    
    // Only bet if the player is in a game. This also gives the player a hand and two cards.
    public function bet($amount=NULL) {
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
    
    // Only let the dealer rake in the amount of money if it isn't more than the player can afford.
    private function ponyUp($amount) {
        if ($this->money >= $amount) {
            $this->money -= $amount;
            $this->game->getDealer()->rakeIn($amount);
        } else {
            throw new Exception('Player cannot bet more than they have.');
        }
    }
    
    public function rakeIn($amount) {
        $this->money += $amount;
    }
    
//    public function play() {
//        
//    }
//    STILL NEEDS TO BE IMPLEMENTED.
    
    public static function shouldDoubleWith($hand) {
        $should = FALSE;
        if ($hand->getValue() === 11) {
            $should = TRUE;
        }
        return $should;
    }
    
    public static function shouldSplitWith($hand) {
        $should = FALSE;
        if ($hand->canSplit() && $this->money >= $hand->bet && $hand->getValue()) {
            $should = TRUE;
        }
        return $should;
    }
    
    public static function shouldStandWith($hand) {
        $should = FALSE;
        if ($hand->getValue() >= 16) {
            $should = TRUE;
        }
        return $should;
    }
    
    public static function shouldSurrenderWith($hand) {
        // Surrendering is almost always a bad idea for players. They shouldn't.
        return FALSE;
    }
    
}