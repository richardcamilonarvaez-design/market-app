<?php
//step 1. Get database connection
    require('../config/database.php');
 /*
    session_start();

    if(!isset($_SESSION['session_user_id'])){
        header('refresh:0;url=error403.html');
    }*/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketapp - List users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-3">
        <table class="table">
            <thead class="table-dark">
                <tr>
                    <th>Fullname</th>
                    <th>E-mail</th>
                    <th>Id number</th>
                    <th>Phone number</th>
                    <th>Status</th>
                    <th>Photo</th>
                    <th>Options</th>
                </tr>
            </thead>
            <?php 
                $sql_users = 
                "select 
                    u.id as user_id,
	                u.firstname ||' '|| u.lastname as fullname,
	                u.email,
	                u.id_number,
	                u.mobile_number,
	                case 
                        when u.status = true then 'Active' else 'Inactive'
	                end as status,
                    u.url_photo
                from users u";

                $result =pg_query($conn_local, $sql_users);
                if(!$result){
                    die("Error". pg_last_error());
                }

                while ($row = pg_fetch_assoc($result)){
                    echo "  <tr>
                            <td> ".$row['fullname']."</td>
                            <td>".$row['email']."</td>
                            <td>".$row['id_number']."</td>
                            <td>".$row['mobile_number']."</td>
                            <td>".$row['status']."</td>
                            <td align='center'><img src=".$row['url_photo']." width='30'></td>
                            <td>
                            <a href ='#'>
                                <img src = 'icons/search.png' width='20'>
                            </a>
                            <a href ='edit_users_form.php?userId=".$row['user_id']."'>
                                <img src = 'icons/refresh.png' width='20'>
                            </a>
                            <a href ='delete_user.php?userId=".$row['user_id']."'>
                                <img src = 'icons/delete.png' width='20'>
                            </a>
                            </td>
                            </tr>";

                }
            ?>
            </table>
        </div>
</body>
</html>