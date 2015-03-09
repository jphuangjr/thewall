<?php
session_start();
include('thewall_connection.php');



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>The Wall</title>
    <meta charset="utf-8">
    <meta name="description" content="The WALL">
    <meta name="author" content="The WALL">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="normalize.css">
    <link rel="stylesheet" href="skeleton.css">
    <style>
        #black{
            border-bottom: 2px solid black;
        }
        .names{
            font-weight: bold;
            font-size: 15px;
            margin-bottom:0px;
        }
        .messages{
            color: midnightblue;
            text-decoration: wavy;
            font-size: 17px;
        }
        .comments{
            color: darkred;
            text-decoration: wavy;
            font-family: times !important;
            font-size: 12px;
            margin-left:40px;

        }
        .comment_names{
            font-weight: bold;
            font-size: 12px;
            margin-left:40px;
            margin-bottom:0px;
        }

    </style>
</head>

<body>
<div class="container">
    <div class="row" >
        <div class="eight columns" style="margin-top: 2%">
            <h3>The WALL</h3>
            <?php
            if(isset($_SESSION['errors'])) {
                foreach ($_SESSION['errors'] as $error) {
                    echo "<p class='error'>{$error}</p><br>";
                }
                unset($_SESSION['errors']);
            }
            ?>
        </div>

        <div class="two columns">
            <h6>Welcome <?=$_SESSION['first_name']?></h6>
        </div>
        <div class="two columns">
            <h6><a href="thewall_login_index.php">Log Off</a></h6>
        </div>
    </div>

    <div class="row">
        <div class="twelve columns">
            <form action="thewall_process.php" method="post">
                <label>Post a message</label>
                <input class="u-full-width" type="text" name="message">
                <input class="button-primary" type="submit" name="submit_message" value="Post a message">
                <input type="hidden" name="action" value="message">
            </form>
        </div>
    </div>
<!-- ------------------------------Retrieves messages from database and displays them-------------------------------------->
    <div class="row">
        <div class="twelve columns">
            <?php
            $query = "SELECT users.first_name, users.last_name, messages.id,messages.created_at, messages.message FROM messages
                      LEFT JOIN users ON users_id = users.id";
            $messages = fetch_all($query);

//            $query_comment = "SELECT users.first_name, users.last_name, comments.created_at, comments.comment, messages.id, comments.id FROM comments
//                              LEFT JOIN messages ON messages_id = messages.id
//                              LEFT JOIN users ON messages.users_id = users.id
//                              WHERE messages.id = {$message['id']}";
//
//            $comments = fetch_all($query_comment);

            foreach(array_reverse($messages) as $message) {
                echo "<p class='names'>" ."{$message['first_name']}" .' ' ."{$message['last_name']}" .' '. "{$message['created_at']}" . "</p><br>";
                echo "<p class='messages'>" . "{$message['message']}". "</p><br>";?>
                <?php
                $query_comment = "SELECT users.first_name, users.last_name, comments.created_at, comments.comment, messages.id, comments.id FROM comments
                              LEFT JOIN messages ON comments.messages_id = messages.id
                              LEFT JOIN users ON comments.users_id = users.id
                              WHERE messages.id = {$message['id']}";
//                echo $query_comment;
//                die();

                $comments = fetch_all($query_comment);
                foreach(array_reverse($comments) as $comment) {

                        echo "<p class='comment_names'>" . "{$comment['first_name']}" . ' ' . "{$comment['last_name']}" . ' ' . "{$comment['created_at']}" . "</p><br>";
                        echo "<p class='comments'>" . "{$comment['comment']}" . "</p><br>";
                    }

                ?>
                <form action="thewall_process.php" method="post">
                    Comment: <input type="text" class="u-full-width" name="comment">
                    <input type="submit" value="Submit Comment" name="submit_comment">
                    <input type="hidden" name="action" value="comment">
                    <input type='hidden' name="message_id" value="<?=$message['id']?>">
                </form><hr>
            <?php
            }
            ?>
        </div>
    </div>




</div>
</body>

</html>