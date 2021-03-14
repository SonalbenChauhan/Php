<?php
include "pagestart.php";
include "handlers.php";

define('TABLE', 'Users');
define('COLUMNS', 'email, password, address, first_name, last_name');


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
    $cmd = 'INSERT INTO ' . TABLE . ' (email, password) ' .
        'VALUES (:email, :password)';
    $sql = $GLOBALS['db']->prepare($cmd);
    var_dump($user['email']);
    $sql->bindValue(':email', $user['email']);
    $sql->bindValue(':password', password_hash($user['password'], PASSWORD_BCRYPT));
    $sql->execute();
}

# DB update for user
function update($user, $id)
{
    # update the record
    $cmd = 'UPDATE ' . TABLE .
        ' SET email = :email, password = :password , address = :address, first_name = :first_name, last_name = :last_name ' .
        'WHERE ID = :id';
    $sql = $GLOBALS['db']->prepare($cmd);
    // var_dump($user);
    $sql->bindValue(':email', $user['email']);
    $sql->bindValue(':address', $user['address']);
    $sql->bindValue(':first_name', $user['first_name']);
    $sql->bindValue(':last_name', $user['last_name']);
    $sql->bindValue(':password', password_hash($user['password'], PASSWORD_BCRYPT));
    $sql->bindValue(':id', $id);
    # execute returns true if the update worked, so we don't actually have to test
    # to see if the record exists before attempting an update.
    // echo $id;
    return $sql->execute();
}


?>