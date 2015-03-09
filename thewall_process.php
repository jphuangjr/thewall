<?php
session_start();
require('thewall_connection.php');

// LOGIN AND REGISTER. Run Login or Register function or destroy session.

if(isset($_POST['action']) && $_POST['action'] == 'login'){
    login_user($_POST);
}
elseif(isset($_POST['action']) && $_POST['action'] == 'register'){
    register_user($_POST);
}

elseif(isset($_POST['action']) && $_POST['action'] == "message") {
    post_message($_POST);
}

elseif(isset($_POST['action']) && $_POST['action'] == "comment") {
    post_comment($_POST);
}

else{
    session_destroy();
    header('Location: thewall_login_index.php');
    die();
}

//Registration Function -----------------------------------------------------------------------------------

function register_user($post){
    $_SESSION['errors'] = array();
    if(empty($post['first_name'])){
        $_SESSION['errors'][] = "Please enter a first name!";
    }
    if(empty($post['last_name'])){
        $_SESSION['errors'][] = "Please enter a last name!";
    }
    if(!filter_var($post['register_email'], FILTER_VALIDATE_EMAIL)){
        $_SESSION['errors'][] = "Please enter a valid email!";
    }
    if(empty($post['register_password'])){
        $_SESSION['errors'][] = "Password field required!";
    }
    if($post['register_password'] !== $post['register_password_confirm']){
        $_SESSION['errors'][] = "Passwords do not match!";
    }
    if(count($_SESSION['errors']) > 0){
        header('Location: thewall_login_index.php');
        die();
    }
    else {
        $esc_first_name = escape_this_string($post['first_name']);
        $esc_last_name = escape_this_string($post['last_name']);
        $esc_register_email = escape_this_string($post['register_email']);
        $esc_register_password = md5($post['register_password']);

        $query = "INSERT INTO users (first_name, last_name, email, pword, created_at )
                  VALUE ('{$esc_first_name}', '{$esc_last_name}', '{$esc_register_email}', '{$esc_register_password}', NOW())";
        run_mysql_query($query);
        $_SESSION['register_success'] = "Registration Successful. Please log in!";
        header('Location: thewall_login_index.php');
        die();

    }

}
//END Registration Function -----------------------------------------------------------------------------------

//Login Function ----------------------------------------------------------------------------------------------

function login_user($post){
    $password2 = md5($post['login_password']);
    $query = "SELECT * FROM users WHERE users.pword = '{$password2}' && users.email = '{$post['login_email']}'";
//    echo $query;
    $user = fetch_all($query);
    if(count($user) > 0 ){
        $_SESSION['user_id'] = $user[0]['id'];
        $_SESSION['first_name'] = $user[0]['first_name'];
        $_SESSION['last_name'] = $user[0]['last_name'];
        $_SESSION['email'] = $user[0]['email'];

        header('Location: thewall_main.php');
    }
    else{
        $_SESSION['errors'][]= "Can't find a user with those login credentials!";
        header('Location: thewall_login_index.php');
    }
}

function post_message($post)
{
            if (empty($post['message'])) {
            $_SESSION['error'][] = "Please enter a message!";
            header('Location: thewall_main.php');

        } else {
            $message = escape_this_string($post['message']);


            $query = "INSERT INTO messages (message, users_id, created_at)
                  VALUE ('{$message}', '{$_SESSION['user_id']} ', NOW())";
            run_mysql_query($query);
            header('Location: thewall_main.php');

        }
 }

function post_comment($post){
    global $connection;
    if (empty($post['comment'])) {
        $_SESSION['error'][] = "Please write a comment!";
    } else {
        $comment = escape_this_string($post['comment']);


        $query_comment = "INSERT INTO comments (comment, users_id , messages_id, created_at)
                  VALUE ('{$comment}', '{$_SESSION['user_id']} ','{$post['message_id']} ', NOW())";
//        echo $query_comment;
        if(!run_mysql_query($query_comment)){
            $_SESSION['errors'][]=$query_comment;
            $_SESSION['errors'][]=$connection->error;
        }
        header('Location: thewall_main.php');

    }

}

?>