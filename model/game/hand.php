<?php

class Hand {

    private $cards = array();
    private $bet;
    private $blackjack = FALSE;
    private $busted = FALSE;
    private $standing = FALSE;
    private $split = FALSE;
    private $doubled = FALSE;
    private $done = FALSE;

    public function __construct($bet) {
        $this->bet = $bet;
    }

    public function __toString() {
        $string = 'This hand ';
        if ($this->blackjack) {
            $string = $string . 'is a blackjack!';
        }
        if ($this->busted) {
            $string = $string . 'has busted.';
        }
        if ($this->standing) { 
            $string = $string . 'has stood.';
        }
        if ($this->split) {
            $string = $string . 'has split.';
        }
        if ($this->doubled) {
            $string = $string . 'has doubled down.';
        }
        if ($this->done) {
            $string = $string . 'is done playing.';
        } else {
            $string = $string . 'is still playing.';
        }
        return $string;
    }

    private function canHit() {
        $canHit = TRUE;
        if ($this->getValue() === 21 || $this->blackjack ||
                                     $this->doubled ||
                                     $this->busted ||
                                     $this->standing) {
            $canHit = TRUE;
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

    private function getValue() {
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
    
    private function checkBlackjack() {
        if ($this->value() === 21 && count($this->cards) === 2) {
            $this->blackjack = TRUE;
            $this->done = TRUE;
        }
    }
    
    private function checkBusted() {
        if ($this->getValue() > 21) {
            $this->busted = TRUE;
            $this->done = TRUE;
        }
    }
    
    public function split() {
        if ($this->canSplit()) {
            $this->split = TRUE;
            $card = array_pop($this->cards);
            return $card;
        } else {
            throw new Exception('Cannot split this hand: ' . $this);
        }
    }
    
    private function canSplit() {
        $canSplit = FALSE;
        if (count($this->cards) === 2) {
            if ($this->cards[0]->getSoftValue() === $this->cards[1]->getSoftValue() && !$this->done) {
                $canSplit = TRUE;
            }
        }
        return $canSplit;
    }
    
    public function double($card) {
        if ($this->canDouble()) {
            $card->flip();
            array_push($this->cards, $card);
            $this->doubled = TRUE;
            $this->done = TRUE;
            $this->checkBusted();
        } else {
            throw new Exception('Cannot double down on this hand: ' . $this);
        }
    }
    
    private function canDouble() {
        return $this->canHit();
    }
    
    public function getBet() {
        return $this->bet;
    }
    
    public function getBlackjack() {
        return $this->blackjack;
    }
    
    public function getBusted() {
        return $this->busted;
    }
    
    public function getDone() {
        return $this->done;
    }
    
    public function getSplit() {
        return $this->split;
    }
    
    public function getDoubled() {
        return $this->doubled;
    }
}
