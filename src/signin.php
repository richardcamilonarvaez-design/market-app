<?php
    //Step 1: get database acces
    require('../config/database.php');

    //Start or create session
    session_start();

    if(isset($_SESSION['session_user_id'])){
        header('refresh:0;url=main.php');
    }else{
        header('refresh:0;url=error403.html');
    }

    //Step 2: get form-data
    $e_mail = trim($_POST['email']);
    $p_wd = trim($_POST['passwd']);

    //$enc_pass = password_hash($p_wd, PASSWORD_DEFAULT);
    $enc_pass = md5($p_wd);

    //step 3: Query to validate data

    //step 3. Query to validate data
    $sql_check_user="
        select
            u.id,
            u.firstname || '' ||u.lastnam as fullname,
            u.email,
            u.password
        from 
            users u
        where 
            u.email = '$e_mail' and
            u.password = '$enc_pass'
        limit 1
    ";
    
    //Step 4. Excute query
    $res_check=pg_query($conn_supa, $sql_check_user);

    $row = pg_fetch_assoc($res_check);
    $_SESSION['session_user_id']=$row['id'];
    $_SESSION['session_user_fullname']=$row['fullname'];

    if(pg_num_rows($res_check) > 0){
        header('refresh:0;url=main.php');
    }else{
        echo "Verify data!!!";
    }
?>