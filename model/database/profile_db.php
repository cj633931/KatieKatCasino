<?php

class ProfileDB {
    
    private static function update_session($username, $session) {
        $db = Database::getDB();
        $query = "UPDATE profiles SET session = :session WHERE username = :username";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":session", $session);
        $stmt->bindValue(":username", $username);
        $stmt->execute();
    }
    
    public static function update_money($profileID, $newMoney) {
        $db = Database::getDB();
        $query = "UPDATE profiles SET money = :money WHERE ID = :profileID";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":money", $newMoney);
        $stmt->bindValue(":profileID", $profileID);
        $stmt->execute();
    }

    public static function add_profile($fName, $lName, $username, $password) {
        $db = Database::getDB();
        $query = 'INSERT INTO profiles(fName, lName, username, password, money) VALUES (:fName, :lName, :username, :password, :money)';
        $statement = $db->prepare($query);
        $statement->bindValue(':fName', $fName);
        $statement->bindValue(':lName', $lName);
        $statement->bindValue(':username', $username);
        $statement->bindValue(":password", $password);
        $statement->bindValue(':money', 1000);
        $statement->execute();
        // This won't return anything, as it's adding a user and nothing else.
    }

    public static function verify_username_exists($value) {
        $db = Database::getDB();
        $query = 'SELECT username FROM profiles WHERE username = :value';
        $statement = $db->prepare($query);
        $statement->bindValue(':value', $value);
        $statement->execute();
        $usernames = $statement->fetchAll();
        // If the number of rows in the results are 1+, it'll mean something matches
        if (count($usernames) > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public static function try_login($username, $password) {
        $db = Database::getDB();
        $query = 'SELECT password FROM profiles WHERE username = :username';
        $stmt = $db->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $result = $stmt->fetchAll();
        $stmt->closeCursor();
        if(count($result) > 0) {
            $hashedPassword = $result[0];
            if(password_verify($password, $hashedPassword['password'])) {
                session_start();
                $_SESSION['session'] = session_create_id();
                ProfileDB::update_session($username, $_SESSION['session']);
                return true;
            }
        }
        return false;
    }
    
    public static function get_top_player() {
        $db = Database::getDB();
        $query = "SELECT username, money FROM profiles ORDER BY money DESC LIMIT 3";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();
        if(empty($results)) {
            return null;
        } else {
            $record = $results[0];
            $profile = new Profile('', '', $record["username"], $record["money"]);
            return $profile;
        }
    }
    
    public static function get_bottom_player() {
        $db = Database::getDB();
        $query = "SELECT username, money FROM profiles ORDER BY money ASC LIMIT 3";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $results = $stmt->fetchAll();
        if(empty($results)) {
            return null;
        } else {
            $record = $results[0];
            $profile = new Profile('', '', $record["username"], $record["money"]);
            return $profile;
        }
    }

    public static function select_all() {
        $db = Database::getDB();
        $query = 'SELECT * FROM profiles';
        $statement = $db->prepare($query);
        $statement->execute();
        $profiles = $statement->fetchAll();
        return $profiles;
    }
    
    public static function get_profile_info($session) {
        $db = Database::getDB();
        $query = "SELECT * FROM profiles WHERE session = :session";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":session", $session);
        $stmt->execute();
        $results = $stmt->fetchAll();
        if(empty($results)) {
            return null;
        } else {
            $record = $results[0];
            $profile = new Profile($record["fName"], $record["lName"], $record["username"], $record["money"]);
            return $profile;
        }
    }
    
    public static function get_profile_id($session) {
        $db = Database::getDB();
        $query = "SELECT ID FROM profiles WHERE session = :session";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":session", $session);
        $stmt->execute();
        $results = $stmt->fetchAll();
        if(empty($results)) {
            return null;
        } else {
            $id = $results[0];
            return $id;
        }
    }
    
    public static function logout($session) {
        $db = Database::getDB();
        $query = "UPDATE profiles SET session = null WHERE session = :session";
        $stmt = $db->prepare($query);
        $stmt->bindValue(":session", $session);
        $stmt->execute();
        $stmt->closeCursor();
    }
}
