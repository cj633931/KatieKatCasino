<?php
require_once 'player.php';
class Dealer extends Player {
    
    private $deck;
    
    public function __construct($deckCount=6) {
        Player::__construct('Dealer', 1000000, 0, 'dealer');
        $this->deck = new Deck($deckCount);
        $this->deck->shuffle();
    }
    
    public function deal() {
        // Generate a new deck if one doesn't exist.
        if (count($this->deck) < 1) {
            $this->deck = new Deck();
            $this->deck->shuffle();
        }
        // Draw, flip, and return a card.
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
    // This will also include a soft 17 hand.
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
    
    // Pay out to players depending on situation.
    public function payOut($player) {
        $dealerHand = $this->hands[0];
        $winnings = 0;
        foreach($player->hands as $hand) {
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
                if ($hand->isDoubled()) {
                    $winnings = $hand->getBet() * 4;
                }
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
    }
   
}
