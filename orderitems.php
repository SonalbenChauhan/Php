<?php
    include "pagestart.php";
    include "handlers.php";

    define('TABLE', 'OrderItems');
    define('COLUMNS', 'ID, quantity, order_id, item_id');

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

        $cmd = 'INSERT INTO ' . TABLE . ' (quantity, order_id, item_id) ' .
            'VALUES (:quantity, :order_id, :item_id)';
        $sql = $GLOBALS['db']->prepare($cmd);
        $sql->bindValue(':quantity', $order['quantity']);

        $sql->bindValue(':order_id',$order['order_id']);
        $sql->bindValue(':item_id',$order['item_id']);
        $sql->execute();
    }

    function update($order, $id){
            $cmd = 'UPDATE '.TABLE.' SET quantity = :quantity WHERE ID= :id';
            $sql = $GLOBALS['db']->prepare($cmd);
            $sql->bindValue(':quantity', $order['quantity']);
            $sql->bindValue(':id', $id);
            return $sql->execute();
    }


?>