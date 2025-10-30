<?php
    //get database acces
    require('../config/database.php');
    //get form data
    $user_id = $_POST['iduser'];
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);

    $sql_get_user = "select * from users where id = $user_id";

    $result = pg_query($conn_local, $sql_get_user);
    if (pg_num_rows($result) > 0) {
        //update query
        $query = "
        UPDATE users
        SET firstname = '$fname', lastname = '$lname'
        WHERE id = '$user_id';
        ";
        //execute query
        $res = pg_query($conn_local, $query);
        //validate result
        if($res){
            //echo "Users has been created sucessfully!!!";
            echo "<script>alert('Sucess !!!')</script>";
            header('refresh:0;url=list_users.php');
        } else {
            echo "Something wrong!";
        }
        
    } else {
        echo "<script>alert('User dont exists !!')</script>";
        header('refresh:0;url=list_users.php');
    }
?>