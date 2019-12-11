<?php include 'header.php'; ?>
<main>
    <h2>Scores</h2>
    <p>This would look nicer if I had more time.</p>
    
    <h2>Most Hands</h2>
    <table>
        <tr>
            <th>
                Player
            </th>
            <th>
                Hands
            </th>
        </tr>
        <?php foreach ($mostHands as $result) { ?>
        <tr>
            <td><?php $result->getBet() ?></td>
            <td><?php $result->getHits() ?></td>
        </tr>
        <?php } ?>
    </table>
    
    <h2>Top Player</h2>
    <table>
        <tr>
            <th>
                Player
            </th>
            <th>
                Winnings
            </th>
        </tr>
        <?php foreach ($topPlayer as $result) { ?>
        <tr>
            <td><?php $result->getBet() ?></td>
            <td><?php $result->getWinnins() ?></td>
        </tr>
        <?php } ?>
    </table>
    
    <h2>Bottom Player</h2>
    <table>
        <tr>
            <th>
                Player
            </th>
            <th>
                Winnings
            </th>
        </tr>
        <?php foreach ($bottomPlayer as $result) { ?>
        <tr>
            <td><?php $result->getBet() ?></td>
            <td><?php $result->getWinnins() ?></td>
        </tr>
        <?php } ?>
    </table>
</main>
<?php include 'footer.php'; ?>