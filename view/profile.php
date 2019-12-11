<?php include 'header.php'; ?>
<main>
    <h2>Hello, <?php echo htmlspecialchars($profile->getFirstName()); ?> <?php echo htmlspecialchars($profile->getLastName()); ?>!</h2>
    <p>There would probably be content here if I had time. Otherwise, here's a database of the last few hands this player has had.</p>
    <table>
        <tr>
            <th>
                Bet
            </th>
            <th>
                Hits
            </th>
            <th>
                Bust?
            </th>
            <th>
                Win?
            </th>
            <th>
                Winnings
            </th>
        </tr>
        <?php 
        if (isset($results)) {
            foreach ($results as $result) { ?>
        <tr>
            <td><?php echo htmlspecialchars($result->getBet()) ?></td>
            <td><?php echo htmlspecialchars($result->getHits()) ?></td>
            <td><?php echo htmlspecialchars($result->getBust()) ?></td>
            <td><?php echo htmlspecialchars($result->getWin()) ?></td>
            <td><?php echo htmlspecialchars($result->getWinnings()) ?></td>
        </tr>
        <?php } }?>
    </table>
</main>
<?php include 'footer.php'; ?>