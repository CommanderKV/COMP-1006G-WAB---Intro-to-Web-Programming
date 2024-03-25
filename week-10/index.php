<?php
    // Start a session
    session_start();

    // Generate a CSRF token
    if (empty($_SESSION["CRSF_TOKEN"])) {
        $_SESSION["CRSF_TOKEN"] = bin2hex(random_bytes(32));
    }
?>

<!DOCTYPE html>

<html lang=en>
    <head>
        <meta charset="UTF-8">
        <title>PHP chat app</title>
    </head>
    <body>
        <?php
            if (!empty($_SESSION["ERROR"])) {
                echo "<p>" . $_SESSION["ERROR"] . "</p>";
                unset($_SESSION["ERROR"]);
            }
        ?>
        <div>
            <h2>Login</h2>
            <form action="process.php" method="GET">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <input type="hidden" name="CRSF_TOKEN" value="<?php echo $_SESSION["CRSF_TOKEN"] ?>">
                <input type="submit" name="submit" value="LOGIN">
            </form>
        </div>

        <div>
            <h2>Sign Up</h2>
            <form action="process.php" method="GET">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
                <br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <br>
                <input type="hidden" name="CRSF_TOKEN" value="<?php echo $_SESSION["CRSF_TOKEN"] ?>">
                <input type="submit" name="submit" value="SIGNUP">
            </form>
        </div>
    </body>
</html>