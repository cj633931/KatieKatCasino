<?php include 'header.php'; ?>
<main>
    <h2>New Profile</h2>
    <form action="?action=create_new_profile" method="post">
        <table>
            <tr>
                <td>First Name</td>
                <td><input type="text" name="fName" value="<?php echo htmlspecialchars($fName); ?>"></td>
                <td><span id="error"><?php echo htmlspecialchars($errors[0]) ?></span></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><input type="text" name="lName" value="<?php echo htmlspecialchars($lName); ?>"></td>
                <td><span id="error"><?php echo htmlspecialchars($errors[1]) ?></span></td>
            </tr>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"></td>
                <td><span id="error"><?php echo htmlspecialchars($errors[2]) ?></span></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password"></td>
                <td><span id="error"><?php echo htmlspecialchars($errors[3]) ?></span></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Confirm"><br>
    </form>
</main>
<?php include 'footer.php';