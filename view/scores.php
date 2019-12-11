<?php include 'header.php'; ?>
<main>
    <h2>Scores</h2>
    <p>This would look nicer if I had more time.</p>
    
    <h2>Top Player</h2>
    <table>
        <tr>
            <th>
                Player
            </th>
            <th>
                Money
            </th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($topPlayer->getUsername()); ?></td>
            <td><?php echo htmlspecialchars($topPlayer->getMoney()); ?></td>
        </tr>
    </table>
    
    <h2>Bottom Player</h2>
    <table>
        <tr>
            <th>
                Player
            </th>
            <th>
                Money
            </th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($bottomPlayer->getUsername()); ?></td>
            <td><?php echo htmlspecialchars($bottomPlayer->getMoney()); ?></td>
        </tr>
    </table>
</main>
<?php include 'footer.php'; ?>