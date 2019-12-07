<?php
$dirname = dirname(__DIR__);
$boom = explode("\\", $dirname);
$basedir = array_pop($boom);
session_start();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Katie Kat's Casino</title>
        <link rel="stylesheet" type="text/css" href="/<?php echo htmlspecialchars($basedir) ?>/style.css">
    </head>
    <body>
        <div id="wrapper">
            <nav role="navigation">
                <ul>
                    <?php if(isset($_SESSION['session'])) { ?>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller?action=logout">Logout</a></li>
                    <?php } else { ?>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller?action=view_login">Login</a></li>
                    <?php } ?>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller?action=view_new_profile">New Profile</a></li>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller?action=view_profile">Profile</a></li>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller?action=view_about">About</a></li>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller?action=view_scores">Scores</a></li>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller?action=view_rules">Rules</a></li>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller?action=view_play">Play</a></li>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>">Home</a></li>
                </ul>
            </nav>
            <header role="banner">
                <h1><a href="/<?php echo htmlspecialchars($basedir) ?>">Katie Kat's Casino</a></h1>
            </header>