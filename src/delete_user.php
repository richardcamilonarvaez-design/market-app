<?php
    // Step 1: get database access
    require('../config/database.php');

    //Step 2:Get dat or params
    $user_id=$_GET['userId'];

    //Step 3: Prepare query
    $sql_delete_user="delete from users where id= $user_id";

    //Step 4: Exucute query
    $result =pg_query($conn_local, $sql_delete_user);
    if(!$result){
        die("error". pg_last_error());
    }else{
        echo"<script>alert('User has been deleted!')</sript>";
        header('refresh:0;url=list_users.php');
    }
?>