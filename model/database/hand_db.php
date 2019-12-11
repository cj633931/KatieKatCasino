<?php

require_once 'handData.php';

class HandDB {

    public static function add_hand($profileID, $bet, $hits, $bust, $win, $winnings) {
        $db = Database::getDB();
        $query = 'INSERT INTO hands(profileID, bet, hits, bust, win, winnings) VALUES (:profileID, :bet, :hits, :bust, :win, :winnings)';
        $statement = $db->prepare($query);
        $statement->bindValue(':profileID', $profileID);
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

    public static function get_recent_hands($sessionID) {
        $profileID = ProfileDB::get_profile_id($sessionID);
        $db = Database::getDB();
        $query = 'SELECT * FROM hands WHERE profileID = :profileID';
        $statement = $db->prepare($query);
        $statement->bindValue(":profileID", $profileID[0]);
        $statement->execute();
        $hands = $statement->fetchAll();
        $handsData = array();
        foreach ($hands as $hand) {
            array_push($handsData, new handData($hand['bet'], $hand['hits'], $hand['bust'], $hand['win'], $hand['winnings']));
        }
        if (isset($handsData[0])) {
            return $handsData;
        } else {
            return NULL;
        }
    }

}
