<?php
require_once 'handData.php';

class HandDB {

    public static function add_hand($bet, $hits, $bust, $win, $winnings) {
        $db = Database::getDB();
        $query = 'INSERT INTO hands(bet, hits, bust, win, winnings) VALUES (:bet, :hits, :bust, :win, :winnings)';
        $statement = $db->prepare($query);
        $statement->bindValue(':bet', $bet);
        $statement->bindValue(':hits', $hits);
        $statement->bindValue(':bust', $bust);
        $statement->bindValue(":win", $win);
        $statement->bindValue(':winnings', $winnings);
        $statement->execute();
    }

    public static function select_all() {
        $db = Database::getDB();
        $query = 'SELECT * FROM hands';
        $statement = $db->prepare($query);
        $statement->execute();
        $hands = $statement->fetchAll();
        $handsData = array();
        foreach ($hands as $hand) {
            array_push($handsData, new handData($hand['bet'], $hand['hits'], $hand['bust'], $hand['win'], $hand['winnings']));
        }
        return $handsData;
    }
    
    public static function most_hands_played() {
        $db = Database::getDB();
        $query = 'SELECT COUNT(profileID) AS "hands" FROM hands ORDER BY profileID DESC';
        $statement = $db->prepare($query);
        $statement->execute();
        $hands = $statement->fetchAll();
        $handsData = array();
        foreach ($hands as $hand) {
            array_push($handsData, new handData($hand[0], $hand['hands'], '', '', ''));
        }
        return $handsData;
    }
    
    public static function get_top_player() {
        $db = Database::getDB();
        $query = 'SELECT SUM(winnings) AS "winnings" FROM hands ORDER BY profileID DESC';
        $statement = $db->prepare($query);
        $statement->execute();
        $hand = $statement->fetchAll();
        return new handData($hand[0], '', '', '','');
    }
    
    public static function get_bottom_player() {
        $db = Database::getDB();
        $query = 'SELECT SUM(winnings) AS "winnings" FROM hands ORDER BY profileID ASC';
        $statement = $db->prepare($query);
        $statement->execute();
        $hand = $statement->fetchAll();
        return new handData($hand[0], '', '', '', '');
    }
    
    public static function get_recent_hands($sessionID) {
        $profileID = ProfileDB::get_profile_id($sessionID);
        $db = Database::getDB();
        $query = 'SELECT * FROM hands WHERE profileID = :profileID ORDER BY handID DESC';
        $statement = $db->prepare($query);
        $statement->bindValue(":profileID", $profileID[0]);
        $statement->execute();
        $hands = $statement->fetchAll();
        $handsData = array();
        foreach ($hands as $hand) {
            array_push($handsData, new handData($hand['bet'], $hand['hits'], $hand['bust'], $hand['win'], $hand['winnings']));
        }
        return $handsData;
    }
}
