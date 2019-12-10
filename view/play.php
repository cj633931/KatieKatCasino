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
    <textarea rows="10" cols="50" readonly><?php echo htmlspecialchars($messages) ?></textarea>
    <p>
        <?php echo htmlspecialchars($error) ?>
    </p>
    <?php if ($isNewHand) { ?>
    <form action="?action=bet" method="post">
        <input type="number" name="bet">
        <input type="submit" value="Bet" >
    </form>
    <?php } ?>
    <?php if ($canSurrender) { ?>
    <form action="?action=surrender" method="post">
        <input type="submit" value="Surrender">
    </form>
    <?php } ?>
    <?php if ($canHit) { ?>
    <form action="?action=hit" method="post">
        <input type="submit" value="Hit">
    </form>
    <?php } ?>
    <?php if ($canStand) { ?>
    <form action="?action=stand" method="post">
        <input type="submit" value="Stand">
    </form>
    <?php } ?>
    <?php if ($canDouble) { ?>
    <form action="?action=double" method="post">
        <input type="submit" value="Double Down">
    </form>
    <?php } ?>
</main>
<?php include 'footer.php'; ?>