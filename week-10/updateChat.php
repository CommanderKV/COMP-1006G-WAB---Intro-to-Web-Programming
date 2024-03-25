<?php
    // Get our DB connection
    require_once "DBConn.php";

    // Start a session
    session_start();

    // Check if the request is valid
    if (!empty($_SESSION["CRSF_TOKEN"]) && !empty($_SESSION["ID"])) {
        // Make a DB connection
        $db = new DBConn();

        // Check if we are updating the chat or adding to it
        if ($_REQUEST["update"] === "true") {
            // Get the messages from the database
            $sql = "SELECT ID_sender, ID_reciver, message, time " . 
                "FROM PHPMSGS WHERE ".
                "(" . 
                "ID_sender = " . $_SESSION["ID"] . " AND " . "ID_reciver = " . $_REQUEST["sendTo"] . 
                ") OR (" .
                "ID_sender = " . $_REQUEST["sendTo"] . " AND " . "ID_reciver = " . $_SESSION["ID"] .
                ") ORDER BY time";

            // Get the messages
            $result = $db->query($sql);

            // Check if we have messages
            if ($result->num_rows > 0) {
                // Output the messages
                while($row = $result->fetch_assoc()) {
                    $thisUser = $db->getUserName($row["ID_sender"]);
                    $sendToUser = $db->getUserName($row["ID_reciver"]);
                    echo "<p>" . $thisUser . " &rarr; " . $sendToUser . ": " . $row["message"] . "</p>";
                }
            } else {
                echo "<p>No messages</p>";
            }

        } else if ($_REQUEST["update"] === "false") {
            // Get the message from the form and sanitize it
            $message = filter_input(INPUT_GET, "message");

            // Insert the message into the database
            $sql = "INSERT INTO PHPMSGS (ID_sender, ID_reciver, message, time) VALUES (" . 
                $_SESSION["ID"] . ", " . 
                $_REQUEST["sendTo"]  . ', "' . 
                $message . '", NOW())';
            
            $result = $db->query($sql);

            // Check if the message was inserted
            if ($result == 1) {
                echo "Message sent";

            } else {
                echo "Error sending message";
            }            
        } else {
            echo "Invalid request";
        }

    } else {
        // If we encounter an invaild request send back debug error
        if (empty($_SESSION["CRSF_TOKEN"])) {
            echo "Invalid request: CSRF_TOKEN-" . $_SESSION["CRSF_TOKEN"];
        
        } else if (empty($_SESSION["ID"])) {
            echo "Invalid request: ID-" . $_SESSION["ID"];
        }
    }
?>