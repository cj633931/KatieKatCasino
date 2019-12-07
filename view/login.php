<?php include 'header.php'; ?>
<main>
    <h2>Login</h2>
    <form action="?action=try_login" method="post">
        <table>
            <tr>
                <span id="error"><?php echo htmlspecialchars($error) ?></span>
            </tr>
            <tr>
                <td>Username</td>
                <td><input type="text" name="username" value="<?php echo htmlspecialchars($username); ?>"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password"></td>
            </tr>
        </table>
        <br>
        <input type="submit" value="Login">
    </form>
</main>
<?php include 'footer.php'; ?>