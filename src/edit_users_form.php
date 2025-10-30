<?php
    // Step 1: get database access
    require('../config/database.php');

    //Step 2:Get dat or params
    $user_id=$_GET['userId'];

    $sql_get_users="select * from users where id=$user_id";
    $result=pg_query($conn_local, $sql_get_users);

    if(!$result){
        die("Error". pg_last_error());
    }

    while ($row = pg_fetch_assoc($result)){
        $fname=$row['firstname'];
        $lname=$row['lastname'];
        $id_number=$row['id_number'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form name="edit-user-form" action="update_user.php" method="post">
        <input
            type="hidden"
            name="iduser"
            value="<?php echo $user_id?>"
            readonly
            required/><br><br>
        <lable>Identificacion number: </lable>
        <input
            type="text"
            name="id_number"
            value="<?php echo $id_number?>"
            readonly
            required
        /><br><br>
        <lable>Firstname: </lable>
        <input
            type="text"
            name="fname"
            value="<?php echo $fname?>"
            required
        /><br><br>
        <lable>Lastname: </lable>
        <input
            type="text"
            name="lname"
            value="<?php echo $lname?>"
            required
        /><br><br>
        <button style="background-color: #007bff; color: white; border: none; padding: 12px 24px; cursor: pointer; border-radius: 12px; font-size: 16px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); transition: background-color 0.3s ease, transform 0.3s ease;">Update user</button>

    </form>
</body>
</html>