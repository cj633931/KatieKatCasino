<?php

class Card {

    private $rank;
    private $suit;
    private $softValue;
    private $hardValue;
    private $ace = FALSE;
    private $face = FALSE;
    private $showing = FALSE;

    const ranks = array('Ace' => 'Ace',
        'Two' => 'Two',
        'Three' => 'Three',
        'Four' => 'Four',
        'Five' => 'Five',
        'Six' => 'Six',
        'Seven' => 'Seven',
        'Eight' => 'Eight',
        'Nine' => 'Nine',
        'Ten' => 'Ten',
        'Jack' => 'Jack',
        'Queen' => 'Queen',
        'King' => 'King');
    const suits = array('Hearts' => 'Hearts',
        'Diamonds' => 'Diamonds',
        'Spades' => 'Spades',
        'Clubs' => 'Clubs');
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

    public function __construct($rank, $suit, $showing = FALSE) {
        // Assign Card a rank if valid.
        if (in_array($rank, Card::ranks)) {
            $this->rank = $rank;
        } else {
            throw new Exception('Invalid card rank: ' . $rank);
        }
        // Assign Card a suit if valid.
        if (in_array($suit, Card::suits)) {
            $this->suit = $suit;
        } else {
            throw new Exception('Invalid card suit: ' . $suit);
        }
        // Is Card an ace?
        if ($this->rank == Card::ranks['Ace']) {
            $this->ace = TRUE;
        }
        // Is Card a face card?
        if (in_array($rank, array(Card::ranks['Jack'], Card::ranks['Queen'], Card::ranks['King']))) {
            $this->face = TRUE;
        }
        // Is Card showing?
        if ($showing === TRUE) {
            $this->showing = TRUE;
        }
        // Set the hard and soft value of the Card.
        if (!isset($this->hardValue) || !isset($this->softValue)) {
            $this->hardValue = Card::hardValues[Card::ranks[$rank]];
            $this->softValue = Card::softValues[Card::ranks[$rank]];
        }
    }
    
    public function __toString() {
        if ($this->isShowing() === TRUE) {
            return $this->rank . ' of ' . $this->suit;
        }
        else {
            return 'Hidden';
        }
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
    
    public function show() {
        $this->showing = TRUE;
    }
    
    public function hide() {
        $this->showing = FALSE;
    }
}