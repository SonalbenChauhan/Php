<?php
include "pagestart.php";
include "handlers.php";

define('TABLE', 'Comments');
define('COLUMNS', 'ID, user_id, item_id, comment_title, comment_body, rating');


$verb = strtolower($_SERVER['REQUEST_METHOD']);

if ($verb == 'get') {
    handleGet(TABLE, COLUMNS);
} else if ($verb == 'post') {
    handlePost('isValidInsert', 'insert');
} else if ($verb == 'put') {
    handlePut('isValidUpdate', 'update');
} else if ($verb == 'delete') {
    handleDelete(TABLE);
}

# validation code for user object on insert
function isValidInsert($user)
{   
    echo $user;
    return isset($user['email']) &&
           isset($user['password']) ;
}

# validation code for user object on update
function isValidUpdate($user, $id)
{
    return isValidInsert($user) && is_numeric($id) && $id > 0;
}

# DB insert for user
function insert($user)
{   
    $cmd = 'INSERT INTO ' . TABLE . ' (user_id, item_id, comment_title, comment_body, rating) ' .
        'VALUES (:user_id, :item_id, :comment_title, :comment_body, :rating)';
    $sql = $GLOBALS['db']->prepare($cmd);
    $sql->bindValue(':user_id', $user['user_id']);
    $sql->bindValue(':item_id', $user['item_id']);
    $sql->bindValue(':comment_title', $user['comment_title']);
    $sql->bindValue(':comment_body', $user['comment_body']);
    $sql->bindValue(':rating', $user['rating']);
    
    $sql->execute();
}

# DB update for user
function update($user, $id)
{
    # update the record
    echo $id;
    $cmd = 'UPDATE ' . TABLE .
        ' SET comment_title = :comment_title, comment_body = :comment_body, rating = :rating ' .
        'WHERE ID = :id';
    $sql = $GLOBALS['db']->prepare($cmd);
    $sql->bindValue(':comment_title', $user['comment_title']);
    $sql->bindValue(':comment_body', $user['comment_body']);
    $sql->bindValue(':rating', $user['rating']);
    $sql->bindValue(':id', $id);
    # execute returns true if the update worked, so we don't actually have to test
    # to see if the record exists before attempting an update.
    return $sql->execute();
}


?>