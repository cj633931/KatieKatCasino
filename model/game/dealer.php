<?php

class Dealer extends Player {
    
    private $deck;
    
    
    public function __construct($deckCount=6) {
        Player::__construct('Dealer', 1000000, 0, 'dealer');
        $this->deck = new Deck($deckCount);
        $this->deck->shuffle();
    }
    
    public function deal() {
        if (count($this->deck) < 1) {
            $this->deck = new Deck();
            $this->deck->shuffle();
        }
        $card = $this->deck->draw();
        $card->flip();
        return $card;
    }
    
    public function shuffle() {
        $this->deck->shuffle();
    }
    
    // The following few methods overwrite Player methods that a dealer
    // isn't legally allowed to do.
    public function shouldSplitWith($hand) {
        return FALSE;
    }
    
    public function shouldDoubleWith($hand) {
        return FALSE;
    }
    
    public function shouldSurrenderWith($hand) {
        return FALSE;
    }
    
    // A dealer, unlike a player, MUST stand on 17 due to house rules.
    public function shouldStandWith($hand) {
        $should = FALSE;
        if ($hand->getValue() >= 17) {
            $should = TRUE;
        }
        return $should;
    }
    
    // Dealer should shuffle if each player isn't allowed 8 cards.
    public function shouldShuffle($playerCount) {
        if (count($this->deck) < ($playerCount * 8)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function payOut($player) {
        $dealerHand = $this->hands;
    }
}
