<?php
    include "pagestart.php";
    include "handlers.php";

    define('TABLE', 'orders');
    define('COLUMNS', 'ID,user_id, grand_total');

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



    function insert($order)
    {
        $cmd = 'INSERT INTO ' . TABLE . ' (user_id) ' .
            'VALUES (:user_id)';
        $sql = $GLOBALS['db']->prepare($cmd);
        $sql->bindValue(':user_id', $order['user_id']);
        return $sql->execute();
        
    }

    function update($order, $id){
            $cmd = 'UPDATE '.TABLE.' SET grand_total = :grand_total WHERE ID= :id';
            $sql = $GLOBALS['db']->prepare($cmd);
            $sql->bindValue(':grand_total', $order['grand_total']);
            $sql->bindValue(':id', $id);
            return $sql->execute();
    }

?>