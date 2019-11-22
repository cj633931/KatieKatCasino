<?php

class Card {

    private $rank;
    private $suit;
    private $softValue;
    private $hardValue;
    private $ace = FALSE;
    private $face = FALSE;
    private $showing = FALSE;

    const ranks = array('A' => 'Ace',
        '2' => 'Two',
        '3' => 'Three',
        '4' => 'Four',
        '5' => 'Five',
        '6' => 'Six',
        '7' => 'Seven',
        '8' => 'Eight',
        '9' => 'Nine',
        '10' => 'Ten',
        'J' => 'Jack',
        'Q' => 'Queen',
        'K' => 'King');
    const suits = array('HEARTS' => '\u2661',
        'DIAMONDS' => '\u2662',
        'SPADES' => '\u2660',
        'CLUBS' => '\u2663');
    const hardValues = array('Ace' => 1,
        'Two' => 2,
        'Three' => 3,
        'Four' => 4,
        'Five' => 5,
        'Six' => 6,
        'Seven' => 7,
        'Eight' => 8,
        'Nine' => 9,
        'Ten' => 10,
        'Jack' => 10,
        'Queen' => 10,
        'King' => 10);
    const softValues = array('Ace' => 11,
        'Two' => 2,
        'Three' => 3,
        'Four' => 4,
        'Five' => 5,
        'Six' => 6,
        'Seven' => 7,
        'Eight' => 8,
        'Nine' => 9,
        'Ten' => 10,
        'Jack' => 10,
        'Queen' => 10,
        'King' => 10);

    public function __construct($cardRank, $cardSuit, $showing = FALSE) {
        $rank = strtoupper($cardRank);
        $suit = strtoupper($cardSuit);
        // Assign Card a rank if valid.
        if (in_array($rank, Card::ranks)) {
            $this->rank = $rank;
        } else {
            throw new Exception('Invalid card rank: ' . $rank);
        }
        // Assign Card a suit if valid.
        if (in_array($suit, Card::suits)) {
            $this->suit = $rank;
        } else {
            throw new Exception('Invalid card suit: ' . $suit);
        }
        // Is Card an ace?
        if ($this->rank == Card::ranks['A']) {
            $this->ace = TRUE;
        }
        // Is Card a face card?
        if (in_array($rank, array(Card::ranks['J'], Card::ranks['Q'], Card::ranks['K']))) {
            $this->face = TRUE;
        }
        // Is Card showing?
        if ($showing == TRUE) {
            $this->showing = $showing;
        }
        // Set the hard and soft value of the Card.
        if (!isset($this->hardValue) || !isset($this->softValue)) {
            $this->hardValue = Card::hardValues[Card::ranks[$rank]];
            $this->softValue = Card::softValues[Card::ranks[$rank]];
        }
    }
    
    public function __toString() {
        return $this->rank . ' of ' . $this->suit;
    }
    
    public function getRank() {
        return $this->rank;
    }

    public function getSuit() {
        return $this->suit;
    }

    public function getSoftValue() {
        return $this->softValue;
    }

    public function getHardValue() {
        return $this->hardValue;
    }

    public function isAce() {
        return $this->ace;
    }

    public function isFace() {
        return $this->face;
    }

    public function isShowing() {
        return $this->showing;
    }
    
    public function flip() {
        $this->showing = !$this->showing;
    }
}