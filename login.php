<?php
include "pagestart.php";
include "handlers.php";

define('TABLE', 'users');

$verb = strtolower($_SERVER['REQUEST_METHOD']);

if ($verb == 'post') {
    # client can post to this route to attempt to log in

    $isLoggedIn = false;

    # get the data the user sent
      $post = trim(file_get_contents("php://input"));

     $data = json_decode($post, true);

    // var_dump($data);

    # look in the users table for a matching email
    $cmd = 'SELECT * FROM users WHERE email = :email';
    $sql = $GLOBALS['db']->prepare($cmd);
    $sql->bindValue(':email', $data['email']);
    $sql->execute();

    # if found, verify the password matches
    $user = $sql->fetch(PDO::FETCH_ASSOC);

    
    if (isset($user)){

        if (password_verify($data['password'], $user['password'])){
            $_SESSION['UserId'] = $user['Id'];
            $isLoggedIn = true;
        }
    }

    # provide a response
    $resp = new stdClass();
    $resp->success = $isLoggedIn;
    $resp->userId = $user['Id'];
    echo json_encode($resp);

} else if ($verb == 'delete') {
    # client can delete to this route to log out
    # this will always succeed
    $_SESSION['UserId'] = 0;
    echo '{"success":"true"}';
}
