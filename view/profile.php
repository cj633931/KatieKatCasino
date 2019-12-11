<?php include 'header.php'; ?>
<main>
    <h2>Hello, <?php echo htmlspecialchars($profile->getFirstName()); ?> <?php echo htmlspecialchars($profile->getLastName()); ?>!</h2>
    <p>There would probably be content here if I had time. Otherwise, here's a database of the last few hands this player has had.</p>
    <table>
        <tr>
            <th>
                Bet Amount
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
        <?php foreach ($results as $result) { ?>
        <tr>
            <td><?php $result->getBet() ?></td>
            <td><?php $result->getHits() ?></td>
            <td><?php $result->getBust() ?></td>
            <td><?php $result->getWin() ?></td>
            <td><?php $result->getWinnins() ?></td>
        </tr>
        <?php } ?>
    </table>
</main>
<?php include 'footer.php'; ?>