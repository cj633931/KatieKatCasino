<?php include 'header.php'; 
 if (!isset($error)) {
    $error = '';
}?>
<main>
    <h2>Play</h2>
    <table>
        <tr>
            <td>Name:</td>
            <td><?php echo htmlspecialchars($_SESSION['player']->getName()); ?></td>
        </tr>
        <tr>
            <td>Money:</td>
            <td><?php echo htmlspecialchars($_SESSION['player']->getMoney()); ?></td>
        </tr>

    </table>
    <br>
    <textarea rows="10" cols="50" readonly><?php echo htmlspecialchars($_SESSION['message']) ?></textarea>
    <p>
        <?php echo htmlspecialchars($error) ?>
    </p>
    <?php if ($_SESSION['isNewHand']) { ?>
    <form action="?action=bet" method="post">
        <input type="number" name="bet">
        <input type="submit" value="Bet" >
    </form>
    <?php } ?>
    <?php if ($_SESSION['canHit']) { ?>
    <form action="?action=hit" method="post">
        <input type="submit" value="Hit">
    </form>
    <?php } ?>
    <?php if ($_SESSION['canStand']) { ?>
    <form action="?action=stand" method="post">
        <input type="submit" value="Stand">
    </form>
    <?php } ?>
    <?php if ($_SESSION['gameOver']) { ?>
    <form action="?action=view_play" method="post">
        <input type="submit" value="Play Again">
    </form>
    <?php } ?>
</main>
<?php include 'footer.php'; ?>