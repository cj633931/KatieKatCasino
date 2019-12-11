<?php

require('../model/database/database.php');
require('../model/database/profile_db.php');
require('../model/database/profile.php');
require('../model/database/hand_db.php');
require('../model/game/game.php');
require("../model/game/dealer.php");
require("../model/game/human.php");

$action = filter_input(INPUT_GET, 'action');

// This switch seems to be a common thing when it comes to action handling.
// It works exactly like an if/else but is cleaner.
switch ($action) {
    case 'view_play':
        session_start();
        if (!isset($_SESSION['session'])) {
            $_SESSION['player'] = new Human('Guest', 1000);
        } else {
            $profile = ProfileDB::get_profile_info($_SESSION['session']);
            $_SESSION['player'] = new Human($profile->getUsername(), $profile->getMoney());
        }
        try {
            $_SESSION['oldMoney'] = $_SESSION['player']->getMoney();
            $_SESSION['game'] = new Game(1, 50);
            $_SESSION['player']->joinGame($_SESSION['game']);
            $_SESSION['game']->addPlayer($_SESSION['player']);
            $_SESSION['isNewHand'] = TRUE;
            $_SESSION['canHit'] = FALSE;
            $_SESSION['canStand'] = FALSE;
            $_SESSION['handWon'] = NULL;
            $_SESSION['message'] = "You sit down at the table.\nThe dealer greets you.\n";
        } catch (Exception $createException) {
            $_SESSION['message'] = "Could not begin game: " . $createException;
        }

        include '../view/play.php';
        break;

    case 'bet':
        session_start();
        $bet = filter_input(INPUT_POST, 'bet', FILTER_VALIDATE_INT);
        if (is_int($bet)) {
            try {
                $_SESSION['hitCount'] = 0;
                $_SESSION['player']->bet($bet);
                $_SESSION['message'] .= "You place $" . $bet . " on the table.\nThe dealer gives you two cards.\n" . $_SESSION['game']->getDealerHand() . $_SESSION['game']->getPlayerHand();
                if ($_SESSION['player']->getHand()->isBlackjack()) {
                    $oldMoney = $_SESSION['player']->getMoney();
                    $_SESSION['game']->getDealer()->payOut($_SESSION['player']);
                    $newMoney = $_SESSION['player']->getMoney();
                    $_SESSION['message'] .= "Nice! You got a blackjack. This hand is over.";
                    $_SESSION['handWon'] = TRUE;
                } else {
                    $_SESSION['isNewHand'] = FALSE;
                    $_SESSION['canHit'] = $_SESSION['player']->getHand()->canHit();
                    $_SESSION['canStand'] = $_SESSION['player']->getHand()->canStand();
                }
            } catch (Exception $betError) {
                $_SESSION['message'] .= $betError->getMessage();
            }
        } else {
            $_SESSION['message'] .= "Bet must be positive integer.\n";
        }
        include '../view/play.php';
        break;

    case 'hit':
        session_start();
        $newCard = $_SESSION['game']->getDealer()->deal();
        $_SESSION['player']->getHand()->hit($newCard);
        $_SESSION['hitCount']++;
        $_SESSION['message'] .= "You knock your hand on the table. You're dealt another card.\n" . $_SESSION['game']->getDealerHand() . $_SESSION['game']->getPlayerHand();
        $_SESSION['player']->getHand()->checkBusted();
        if ($_SESSION['player']->getHand()->isBusted()) {
            $_SESSION['message'] .= "Darn! You busted. This hand is over.";
            $_SESSION['canHit'] = $_SESSION['player']->getHand()->canHit();
            $_SESSION['canStand'] = $_SESSION['player']->getHand()->canStand();
            $_SESSION['handWon'] = FALSE;
        }
        if ($_SESSION['player']->getHand()->getValue() === 21) {
            $_SESSION['message'] .= "Sweet! You got 21. Let's see if the dealer can do the same.\n" . $_SESSION['game']->getDealerHand() . $_SESSION['game']->getPlayerHand();
            $_SESSION['canHit'] = $_SESSION['player']->getHand()->canHit();
            $_SESSION['canStand'] = $_SESSION['player']->getHand()->canStand();
            play_dealer();
        }
        include '../view/play.php';
        break;

    case 'stand':
        session_start();
        $_SESSION['message'] .= "You wave your hand over your cards. The dealer nods.\n" . $_SESSION['game']->getDealerHand() . $_SESSION['game']->getPlayerHand();
        $_SESSION['player']->getHand()->stand();
        play_dealer();
        $_SESSION['canHit'] = FALSE;
        $_SESSION['canStand'] = FALSE;
        include '../view/play.php';
        break;

    case 'view_rules':
        include '../view/rules.php';
        break;

    case 'view_scores':
        $mostHands = HandDB::most_hands_played();
        $topPlayer = HandDB::get_top_player();
        $bottomPlayer = HandDb::get_bottom_player();
        include '../view/scores.php';
        break;

    case 'view_about':
        include '../view/about.php';
        break;

    case 'view_profile':
        session_start();
        if (isset($_SESSION['session'])) { // Redirect if they aren't logged in
            $results = HandDB::get_recent_hands($_SESSION['session']);
            $profile = ProfileDB::get_profile_info($_SESSION['session']);
            include '../view/profile.php';
        } else {
            if (!isset($username)) {
                $username = '';
            }
            if (!isset($error)) {
                $error = '';
            }
            $password = '';
            include '../view/login.php';
        }
        break;

    case 'view_login':
        if (!isset($username)) {
            $username = '';
        }
        if (!isset($error)) {
            $error = '';
        }
        $password = '';
        include '../view/login.php';
        break;

    case 'try_login':
        // Grab username and password and attempt to login.
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        validate_profile_login($username, $password);
        break;

    case 'view_new_profile':
        // These if statements will fill the form with empty strings
        if (!isset($fName)) {
            $fName = '';
        }
        if (!isset($lName)) {
            $lName = '';
        }
        if (!isset($username)) {
            $username = '';
        }
        if (!isset($errors)) {
            $errors = array('', '', '', '');
        }
        $password = '';
        include '../view/new_profile.php';
        break;

    case 'create_new_profile':
        // Retrieve user input and instantiate values
        $fName = filter_input(INPUT_POST, 'fName');
        $lName = filter_input(INPUT_POST, 'lName');
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $errors = validate_profile($fName, $lName, $username, $password);
        if (find_error($errors)) {
            include '../view/new_profile.php';
        } else {
            $password = password_hash($password, PASSWORD_BCRYPT);
            ProfileDB::add_profile($fName, $lName, $username, $password);
            include '../view/profile.php';
        }
        break;

    case 'logout':
        session_start();
        ProfileDB::logout($_SESSION["session"]);
        unset($_SESSION["session"]);
        include "../index.php";
        break;
}

function play_dealer() {
    $_SESSION['game']->getDealer()->getHand()->getCards()[1]->show();
    $_SESSION['message'] .= "The dealer flips over the hidden card.\n" . $_SESSION['game']->getDealerHand(TRUE) . $_SESSION['game']->getPlayerHand();
    ;
    while (!$_SESSION['game']->getDealer()->shouldStand()) {
        $newCard = $_SESSION['game']->getDealer()->deal();
        $_SESSION['game']->getDealer()->getHand()->hit($newCard);
        $_SESSION['message'] .= "The dealer adds a card to his hand.\n" . $_SESSION['game']->getDealerHand(TRUE) . $_SESSION['game']->getPlayerHand();
        if ($_SESSION['game']->getDealer()->getHand()->checkBusted() === TRUE) {
            $_SESSION['message'] .= "The dealer busted! You win.";
            $_SESSION['handWon'] = TRUE;
        } elseif ($_SESSION['game']->getDealer()->shouldStand()) {
            $_SESSION['message'] .= "The dealer stands.\n";
            if ($_SESSION['game']->getDealer()->getHand()->getValue() > $_SESSION['player']->getHand()->getValue()) {
                $_SESSION['message'] .= "Shucks. The dealer stood with a higher value than you. This hand is over.";
                $_SESSION['handWon'] = FALSE;
            } elseif ($_SESSION['game']->getDealer()->getHand()->getValue() < $_SESSION['player']->getHand()->getValue()) {
                $_SESSION['message'] .= "Righteous! You stood with a higher value than the dealer. This hand is over.";
                $_SESSION['handWon'] = TRUE;
            } else {
                $_SESSION['message'] .= "That's awkward. You and the dealer have the same value. This hand is over.";
                $_SESSION['handWon'] = NULL;
            }
        }
    }
    $_SESSION['game']->getDealer()->payOut($_SESSION['player']);
    $bet = $_SESSION['player']->getHand()->getBet();
    $hits = $_SESSION['hitCount'];
    $bust = $_SESSION['player']->getHand()->isBusted();
    $win = $_SESSION['handWon'];
    $winnings = $_SESSION['player']->getMoney() - $_SESSION['oldMoney'];
    store_data($bet, $hits, $bust, $win, $winnings);
}

function store_data($bet, $hits, $bust, $win, $winnings) {
    HandDB::add_hand($bet, $hits, $bust, $win, $winnings);
}

function validate_profile($fName, $lName, $username, $password) {
    // Validate user input and find possible errors
    $errors = array('', '', '', '');
    $errors[0] = validate_first_name($fName);
    $errors[1] = validate_last_name($lName);
    $errors[2] = validate_username($username);
    $errors[3] = validate_password($password);
    return $errors;
}

function validate_first_name($fName) {
// Makes sure that first name is not empty
    $message = '';
    if (empty($fName)) {
        $message = 'First name is required.';
    }
    return $message;
}

function validate_last_name($lName) {
// Makes sure that last name is not empty
    $message = '';
    if (empty($lName)) {
        $message = 'Last name is required.';
    }
    return $message;
}

function validate_username($username) {
// Makes sure that the username isn't empty or taken
    $message = '';
    if (empty($username)) {
        $message = 'Username is required.';
    } else if (ProfileDB::verify_username_exists($username)) {
        $message = 'Username is already taken.';
    }
    return $message;
}

function validate_password($pwd) {
// Validates if password matches the required limits
    $lowercaseValueRegex = '/[a-z]/';
    $uppercaseValueRegex = '/[A-Z]/';
    $digitValueRegex = '/[0-9]/';
    $specCharRegex = '/[^a-z0-9\s]/';
    $message = "";
    if (empty($pwd)) {
        $message = "Password cannot be empty.";
    } else if (strlen($pwd) < 8) {
        $message = "Password must be at least 8 characters long.";
    } else if (!preg_match($lowercaseValueRegex, $pwd)) {
        $message = "Password must contain a lowercase letter";
    } else if (!preg_match($uppercaseValueRegex, $pwd)) {
        $message = "Password must contain an uppercase letter.";
    } else if (!preg_match($digitValueRegex, $pwd)) {
        $message = "Password must contain a digit.";
    } else if (!preg_match($specCharRegex, $pwd)) {
        $message = "Password must contain at least one special character.";
    }
    return $message;
}

function find_error($errors) {
// Looks through message array and finds any errors
    foreach ($errors as $error) {
        if ($error != '') {
            return TRUE;
        }
    }
    return FALSE;
}

function validate_profile_login($username, $password) {
    if (ProfileDB::try_login($username, $password)) {
        $profile = ProfileDB::get_profile_info($_SESSION["session"]);
        include '../view/profile.php';
    } else {
        if (!isset($username)) {
            $username = '';
        }
        if (!isset($error)) {
            $error = 'Invalid credentials.';
        }
        $password = '';
        include '../view/login.php';
    }
}
