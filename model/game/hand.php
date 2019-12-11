<?php

class Hand {

    private $cards = array();
    private $bet;
    private $blackjack = FALSE;
    private $busted = FALSE;
    private $standing = FALSE;
    private $done = FALSE;

    public function __construct($bet) {
        $this->bet = $bet;
    }

    public function __toString() {
        $string = "| ";
        foreach ($this->cards as $card) {
            $string .= $card ." | ";
        }
        return $string;
    }

    public function canHit() {
        $canHit = TRUE;
        if ($this->getValue() === 21 || $this->blackjack ||
                                     $this->busted ||
                                     $this->standing) {
            $canHit = FALSE;
        }
        return $canHit;
    }

    public function hit($card) {
        if ($this->canHit()) {
            array_push($this->cards, $card);
            $this->checkBlackjack();
            $this->checkBusted();
        } else {
            throw new Exception('Cannot hit on this hand: ' . $this);
        }
    }
    
    public function stand() {
        $this->standing = TRUE;
        $this->done = TRUE;
    }

    public function getValue() {
        $value = $this->getSoftValue();
        if ($value > 21) {
            $value = $this->getHardValue();
        }
        return $value;
    }

    private function getHardValue() {
        $value = 0;
        foreach ($this->cards as $card) {
            $value += $card->getHardValue();
        }
        return $value;
    }

    private function getSoftValue() {
        $value = 0;
        foreach ($this->cards as $card) {
            $value += $card->getSoftValue();
        }
        return $value;
    }
    
    public function checkBlackjack() {
        if ($this->getValue() === 21 && count($this->cards) === 2) {
            $this->blackjack = TRUE;
            $this->done = TRUE;
        }
    }
    
    public function checkBusted() {
        if ($this->getValue() > 21) {
            $this->busted = TRUE;
            $this->done = TRUE;
        }
    }
    
    public function canStand() {
        if ($this->isDone()) {
            return FALSE;
        }
        else {
            return TRUE;
        }
    }
    
    
    public function getCards() {
        return $this->cards;
    }

    public function getBet() {
        return $this->bet;
    }

    public function isBlackjack() {
        return $this->blackjack;
    }

    public function isBusted() {
        return $this->busted;
    }

    public function isStanding() {
        return $this->standing;
    }

    public function isDone() {
        return $this->done;
    }

    public function setCards($cards) {
        $this->cards = $cards;
    }

    public function setBet($bet) {
        $this->bet = $bet;
    }

    public function setBlackjack($blackjack) {
        $this->blackjack = $blackjack;
    }

    public function setBusted($busted) {
        $this->busted = $busted;
    }

    public function setStanding($standing) {
        $this->standing = $standing;
    }

    public function setDone($done) {
        $this->done = $done;
    }


}