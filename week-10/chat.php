<?php
    // Start a session
    session_start();

    // Generate a CSRF token
    if (empty($_SESSION["CRSF_TOKEN"])) {
        $_SESSION["error"] = "Timed out, please log back in";
        header("Location: index.php");
    } else if ($_SESSION["CRSF_TOKEN"] !== $_SESSION["CRSF_VERIFY_TOKEN"]) {
        $_SESSION["error"] = "CSRF token not valid";
        header("Location: index.php");
    }

    // Get our DB connection
    require_once "DBConn.php";

    // Connect to DB
    $db = new DBConn();
?>

<!DOCTYPE html>

<html lang=en>
    <head>
        <meta charset="UTF-8">
        <title>PHP chat app</title>
        <script defer>
            // ------------
            //   J Querry
            // ------------
            // Load the chat messages
            function loadMessages() {
                var sendToUsername = document.querySelector("select").value;

                var xhr = new XMLHttpRequest();
                xhr.open(
                    "GET", 
                    "updateChat.php?update=true" + 
                    "&sendTo=" + 
                    encodeURIComponent(sendToUsername), 
                    true
                );
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Update the chat with the received messages
                        document.getElementById("chat").innerHTML = xhr.responseText;
                    }
                };
                xhr.send();
            }

            // Send a message to the server
            function sendMessage() {
                var message = document.getElementById("message").value;
                var sendToUsername = document.querySelector("select").value;

                var xhr = new XMLHttpRequest();
                xhr.open(
                    "GET", 
                    "updateChat.php?update=false&message=" + 
                    encodeURIComponent(message) + 
                    "&sendTo=" + 
                    encodeURIComponent(sendToUsername), 
                    true
                );  
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Message sent successfully, update the chat
                        loadMessages();
                    }
                };
                xhr.send();
            }

            // --------------
            //   JavaScript
            // --------------
            
            document.addEventListener("DOMContentLoaded", function() {
                // Attach event listener to the form submit event
                document.querySelector("form").addEventListener("submit", function(event) {
                    // Prevent the form from submitting normally
                    event.preventDefault(); 

                    // Send the message
                    sendMessage();

                    // Clear the input field
                    document.getElementById("message").value = ""; 
                });

                // Load inital messages
                loadMessages();

                // Load messages every 5 seconds
                setInterval(loadMessages, 5000);
            });
        </script>
    </head>
    <body>
        <h1>Welcome to the chat</h1>
        <h2>Chat</h2>
        <div id="chat">
            <p>Loading chat...</p>
        </div>
        <form action="updateChat.php" method="POST">
            <select name="username" required>
                <?php
                    // Get the list of users
                    $sql = "SELECT ID, username FROM PHPUSERS";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["ID"] . "'>" . $row["username"] . "</option>";
                        }
                    }
                ?>
            </select>
            <input type="text" id="message" name="message" required>
            <input type="submit" name="submit" value="SEND">
        </form>
        <a href="index.php">Logout</a>
    </body>
</html>
