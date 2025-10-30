<?php 
    //Step 1. Get database connection
    require('../config/database.php');
    
    //Step 2. Get form-data
    $user_id = $_POST['iduser'];
    $f_name = trim($_POST['fname']);
    $l_name = trim($_POST['lname']);

    //Step 3. Udate query
    $sql_update_user = "
        update users set
            firstname = '$f_name',
            lastname = '$l_name'
        where
            id = $user_id
    ";
    $result = pg_query($conn_local, $sql_update_user);

    if($result){
            //echo "User has beevan created successfully !!!";
            echo "<script>alert('Update Success !!!')</script>";+
            header('refresh:0;url=list_users.php');
        }else{
            echo "Something wrong!";
        }
?>