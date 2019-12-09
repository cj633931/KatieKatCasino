<?php include 'header.php'; ?>
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
    <textarea rows="10" cols="50" readonly>
You sit down at the table.
The dealer greets you.</textarea>
    <?php if ($isNewHand) { ?>
    <form action="?start_game" method="post">
        <input type="number" name="betAmount">
        <input type="submit" value="Bet" >
    </form>
    <?php } ?>
    <?php if ($canSurrender) { ?>
    <form action="?surrender" method="post">
        <input type="submit" value="Surrender">
    </form>
    <?php } ?>
    <?php if ($canHit) { ?>
    <form action="?hit" method="post">
        <input type="submit" value="Hit">
    </form>
    <?php } ?>
    <?php if ($canStand) { ?>
    <form action="?stand" method="post">
        <input type="submit" value="Stand">
    </form>
    <?php } ?>
    <?php if ($canDouble) { ?>
    <form action="?double" method="post">
        <input type="submit" value="Double Down">
    </form>
    <?php } ?>
    <?php if ($canSplit) { ?>
    <form action="?split" method="post">
        <input type="submit" value="Split">
    </form>
    <?php } ?>
</main>
<?php include 'footer.php'; ?>