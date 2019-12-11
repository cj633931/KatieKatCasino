<?php

class handData {

    private $bet;
    private $hits;
    private $bust;
    private $win;
    private $winnings;

    public function __construct($bet='', $hits='', $bust='', $win='', $winnings='') {
        $this->bet = $bet;
        $this->hits = $hits;
        $this->bust = $bust;
        $this->win = $win;
        $this->winnings = $winnings;
    }
    
    public function getBet() {
        return $this->bet;
    }

    public function getHits() {
        return $this->hits;
    }

    public function getBust() {
        return $this->bust;
    }

    public function getWin() {
        return $this->win;
    }

    public function getWinnings() {
        return $this->winnings;
    }

    public function setBet($bet) {
        $this->bet = $bet;
    }

    public function setHits($hits) {
        $this->hits = $hits;
    }

    public function setBust($bust) {
        $this->bust = $bust;
    }

    public function setWin($win) {
        $this->win = $win;
    }

    public function setWinnings($winnings) {
        $this->winnings = $winnings;
    }
}