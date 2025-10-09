<?php
    //Step 1: get database acces
    require('../config/database.php');

    //Step 2: get form data
    $f_name = trim($_POST['fname']);
    $l_name = trim($_POST['lname']);    
    $m_number = trim($_POST['mnumber']);
    $id_number = trim($_POST['idnumber']);
    $e_mail = trim($_POST['email']);
    $p_wd = trim($_POST['passwd']);

    //$enc_pass = password_hash($p_wd, PASSWORD_DEFAULT);
    $enc_pass = md5($p_wd);

    $check_email= "
        SELECT
            u.email
        FROM
            users u
        WHERE
            email='$e_mail' or id_number='$id_number'
        LIMIT 1
    ";
    $res_check=pg_query($conn_supa, $check_email);
    if(pg_num_rows($res_check)>0){
        echo "<sript>alert('Succes !!! Go to login')</script";
        header('refresh:0; url=signup.html');
    }else{
        //Step 3: create query to insert into
        $query="
            INSERT INTO users (
                firstname,
                lastname,
                mobile_number, 
                id_number,
                email,
                password
            ) VALUES (
                '$f_name', 
                '$l_name', 
                '$m_number', 
                '$id_number', 
                '$e_mail', 
                '$enc_pass'
            )
        ";

        //Step 4: Execute query
        $res=pg_query($conn_supa, $query);

        //Step 5: Validate result
        if($res){
            echo "<sript>alert('Succes !!! Go to login')</script";
            header('refresh:0; url=signin.html');
        }else{
            echo "Something wrong";
        }
    }
    ?>