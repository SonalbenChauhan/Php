<?php
    include "pagestart.php";
    include "handlers.php";

    define('TABLE', 'orders');
    define('COLUMNS', 'ID,user_id, grand_total');

    $verb = strtolower($_SERVER['REQUEST_METHOD']);


    if ($verb == 'get') {
        handleOHistory();
    } else if ($verb == 'post') {
        handlePost('isValidInsert', 'insert');
    } else if ($verb == 'put') {
        handlePut('isValidUpdate', 'update');
    } else if ($verb == 'delete') {
        handleDelete(TABLE);
    }

    function handleOHistory(){
        try{
            if (isset($_SERVER['PATH_INFO'])) {
                $id = substr($_SERVER['PATH_INFO'], 1);
            }
            if (isset($id) && is_numeric($id)) {
                $cmd  = 'SELECT * FROM '.TABLE.' where user_id = :user_id';
                $sql = $GLOBALS['db']->prepare($cmd);
                $sql->bindValue(':user_id', $id);
                $sql->execute();
            }
            echo json_encode($sql->fetchAll(PDO::FETCH_ASSOC));
        }catch(Exception $e){
            
        }

    }

?>