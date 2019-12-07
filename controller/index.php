<?php

require('../model/database/database.php');
require('../model/database/profile_db.php');
require('../model/database/profile.php');
require('../model/game/game.php');
require("../model/game/dealer.php");
require("../model/game/human.php");

$action = filter_input(INPUT_GET, 'action');

// This switch seems to be a common thing when it comes to action handling.
// It works exactly like an if/else but is cleaner.
switch ($action) {
    case 'view_play':
        session_start();
        if (!isset($_SESSION['user'])) {
//////////////////////////////////////////////////////////////
        } else {
            $user = $_SESSION['user'];
        }
        include '../view/play.php';
        break;

    case 'run_game':
        session_start();
        $user = $_SESSION['user'];
        $player = new Human($name, $money, $initialBet);
        break;

    case 'view_rules':
        include '../view/rules.php';
        break;

    case 'view_scores':
        include '../view/scores.php';
        break;

    case 'view_about':
        include '../view/about.php';
        break;

    case 'view_profile':
        session_start();
        if (isset($_SESSION['session'])) { // Redirect if they aren't logged in
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