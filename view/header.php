<?php
$dirname = dirname(__DIR__);
$boom = explode("\\", $dirname);
$basedir = array_pop($boom);
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
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller/website?action=view_login">Login</a></li>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller/website?action=view_profile">Profile</a></li>
                                        <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller/website?action=view_about">About</a></li>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller/website?action=view_scores">Scores</a></li>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller/website?action=view_rules">Rules</a></li>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>/controller/website?action=view_play">Play</a></li>
                    <li><a href="/<?php echo htmlspecialchars($basedir) ?>">Home</a></li>
                </ul>
            </nav>
            <header role="banner">
                <h1><a href="/<?php echo htmlspecialchars($basedir) ?>">Katie Kat's Casino</a></h1>
            </header>
            