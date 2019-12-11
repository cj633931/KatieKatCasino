<?php

require_once 'player.php';
require_once 'deck.php';

class Dealer extends Player {

    private $deck;

    public function __construct($deckCount = 6) {
        Player::__construct('Dealer', 1000000, 'dealer');
        try {
            $this->deck = new Deck($deckCount);
            $this->deck->shuffle();
            $newHand = new Hand(0);
            $shownCard = $this->deal();
            $newHand->hit($shownCard);
            $hiddenCard = $this->deal(TRUE);
            $newHand->hit($hiddenCard);
            $this->hand = $newHand;
        } catch (Exception $deckException) {
            throw new Exception('Could not create dealer: ' . $deckException);
        }
    }

    public function __toString() {
        return $this->getName();
    }

    public function deal($asHidden = FALSE) {
        // Generate a new deck if one doesn't exist.
        if ($this->deck->count() < 1) {
            $this->deck = new Deck();
            $this->deck->shuffle();
        }
        // Draw, flip, and return a card.
        if ($asHidden) {
            $card = $this->deck->draw();
        } else {
            $card = $this->deck->draw();
            $card->show();
        }
        return $card;
    }

    public function shuffle() {
        $this->deck->shuffle();
    }

    // A dealer, unlike a player, MUST stand on 17 due to house rules.
    // This will also include a soft 17 hand.
    public function shouldStand() {
        $should = FALSE;
        if ($this->hand->getValue() >= 17) {
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

    // Pay out to players depending on situation.
    public function payOut($player) {
        $dealerHand = $this->hand;
        $winnings = 0;
        $hand = $player->getHand();
        // If the player's hand busted, they don't win.
        if ($hand->isBusted()) {
            $winnings = 0;
        }
        // If the player's hand is a blackjack, they win 2.5x their bet.
        elseif ($hand->isBlackjack()) {
            $winnings += $hand->getBet() * 2.5;
        }
        // If the dealer busted, payout depending on bet.
        elseif ($dealerHand->isBusted()) {
            $winnings = $hand->getBet() * 2;
        }
        // If the dealer's hand is equal to the player's hand, push.
        elseif ($dealerHand->getValue() == $hand->getValue()) {
            $winnings = $hand->getBet();
        }
        // If the dealer's hand is higher but no bust
        elseif ($dealerHand->getValue() > $hand->getValue()) {
            $winnings = 0;
        }
        // If the player's hand is higher but no bust
        elseif ($dealerHand->getValue() < $hand->getValue()) {
            $winnings = $hand->getBet() * 2;
        }
        $player->rakeIn($winnings);
    }

    public function getHand() {
        return $this->hand;
    }

}
