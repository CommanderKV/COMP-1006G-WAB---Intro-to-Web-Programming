<?php
    // Get our DB connection
    require_once "DBConn.php";

    // Start a session
    session_start();

    // Check if the request is valid
    if ($_GET["CRSF_TOKEN"] !== $_SESSION["CRSF_TOKEN"]) {
        $_SESSION["ERROR"] = "CSRF token not valid " . $_GET["CRSF_TOKEN"] . "|---|" . $_SESSION["CRSF_TOKEN"];
        header("Location: index.php");
    }

    // Store the CSRF token
    $_SESSION["CRSF_VERIFY_TOKEN"] = $_GET["CRSF_TOKEN"];

    if ($_GET["submit"] === "SIGNUP") {
        // Get the data from the form and ssanitaize it
        $username = trim(filter_input(INPUT_GET, "username"));
        $password = trim(filter_input(INPUT_GET, "password"));
        $email = trim(filter_input(INPUT_GET, "email", FILTER_VALIDATE_EMAIL));
        
        if (strlen($username) < 3) {
            $_SESSION["error"] = "Username must be at least 3 characters with no leadin or trailing whitespaces";
            header("Location: index.php");
        } else if (strlen($password) < 8) {
            $_SESSION["error"] = "Password must be at least 8 characters with no leading or trailing whitespaces";
            header("Location: index.php");
        } else if ($email === FALSE) {
            $_SESSION["error"] = "Invalid email.";
            header("Location: index.php");
        }

        // Create a new instance of the DBConn class
        $db = new DBConn();

        // Check if the username is already taken
        $sql = "SELECT * FROM PHPUSERS WHERE username = '$username'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            die("Username already taken");// TODO
        }

        // Hash the password
        $password = hash('sha256', $password);

        // Insert the user into the database
        $sql = "INSERT INTO PHPUSERS (username, password, email) VALUES ('$username', '$password', '$email')";
        $result = $db->query($sql);

        if ($result === TRUE) {
            $sql = "SELECT * FROM PHPUSERS WHERE username = '$username' AND password = '$password'";
            $result = $db->query($sql);
            
            $_SESSION["username"] = $username;
            $_SESSION["ID"] = $result->fetch_assoc()["ID"];

            header("Location: chat.php");

        } else {
            $_SESSION["ERROR"] = "Error creating user";
            header("Location: index.php");
        }

    } else if ($_GET["submit"] === "LOGIN") {
        // Get the data from the form and ssanitaize it
        $username = trim(filter_input(INPUT_GET, "username"));
        $password = trim(filter_input(INPUT_GET, "password"));
        
        // Create a new instance of the DBConn class
        $db = new DBConn();

        // Hash the password
        $password = hash('sha256', $password);

        // Check if the user exists
        $sql = "SELECT * FROM PHPUSERS WHERE username = '$username' AND password = '$password'";
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            // Store vairables for chatting
            $_SESSION["username"] = $username;
            $_SESSION["ID"] = $result->fetch_assoc()["ID"];
            echo "ID: " . $_SESSION["ID"];
            // Redirect to the chat page
            header("Location: chat.php");

        } else {
            // Store error to display on index.php
            $_SESSION["ERROR"] = "Invalid username or password";
            header("Location: index.php");
        }
    }


?>