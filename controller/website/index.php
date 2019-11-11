<?php
$dirname = dirname(__DIR__);
$boom = explode("\\", $dirname);
$basedir = array_pop($boom);

//array_pop(explode("\\", dirname(__DIR__))) 

require('../../model/database/database.php');
require('../../model/database/profile_db.php');
require('../../model/database/profile.php');

$action = filter_input(INPUT_GET, 'action');

// This switch seems to be a common thing when it comes to action handling.
// It works exactly like an if/else but is cleaner.
switch ($action) {
    case '':
        include $basedir;
        break;
    
    case 'view_play':
        break;
    
    case 'view_rules':
        break;
    
    case 'view_scores':
        break;
    
    case 'view_about':
        break;
    
    case 'view_profile':
        session_start();
        if (!isset($_SESSION['session'])) { // Redirect if they aren't logged in
            $profile = ProfileDB::get_profile_info($_SESSION['session']);
            include $basedir . '/view/profile.php';
        } else {
            include $basedir . '/view/view_login.php';
        }
        break;
    
    case 'view_login':
        include $basedir . '/view/login.php';
        break;
    
    case 'try_login':
        $username = filter_input(INPUT_POST, "username");
        $password = filter_input(INPUT_POST, "password");
        validate_user_login($username, $password);
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
        if (!isset($messages)) {
            $messages = array('', '', '', '');
        }
        $password = '';
        include $basedir . '/view/new_profile.php';
        break;
        
    case 'create_new_profile':
        // Retrieve user input and instantiate values
        $fName = filter_input(INPUT_POST, 'fName');
        $lName = filter_input(INPUT_POST, 'lName');
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');
        
        $messages = validate_profile($fName, $lName, $username, $password);
        if (find_error($messages)) {
            include $basedir . '/view/new_profile.php';
        } else {
            $password = password_hash($password, PASSWORD_BCRYPT);
            ProfileDB::add_profile($fName, $lName, $username, $password);
            include $basedir . '/view/profile.php';
        }
        break;
}