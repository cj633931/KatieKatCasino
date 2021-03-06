<?php

require_once 'card.php';

class Deck {

    private $cards = array();

    public function __construct($deckCount = 6) {
        $decksCreated = 0;
        // Create number of decks requested.
        while ($deckCount > $decksCreated) {
            foreach (Card::suits as $suit) {
                foreach (Card::ranks as $rank) {
                    try {
                        $newCard = new Card($rank, $suit);
                        array_push($this->cards, $newCard);
                    } catch (Exception $newCardException) {
                        throw new Exception('Could not create deck: '.$newCardException->getMessage());
                    }
                }
            }
            $decksCreated++;
        }
    }

    public function __toString() {
        $string = '';
        // For each card, add to string nicely.
        foreach ($this->cards as $card) {
            $string = $card . ', ';
        }
        return string;
    }

    public function shuffle() {
        shuffle($this->cards);
    }

    public function draw() {
        if ($this->count() >= 1) {
            $cardDrawn = array_pop($this->cards);
        } else {
            throw new Exception('No cards left to draw!');
        }
        return $cardDrawn;
    }

    public function count() {
        return count($this->cards);
    }

}
