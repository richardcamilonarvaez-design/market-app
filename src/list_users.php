<?php
//Step 1: get database acces
require('../config/database.php')
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
                    <th>phone number</th>
                    <th>status</th>
                    <th>options</th>
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
	                end as status
                from users u";

                $result =pg_query($conn_local, $sql_users);
                if(!$result){
                    die("error". pg_last_error());
                }

                while ($row = pg_fetch_assoc($result)){
                    echo "  <tr>
                            <td> ".$row['fullname']."</td>
                            <td>".$row['email']."</td>
                            <td>".$row['id_number']."</td>
                            <td>".$row['mobile_number']."</td>
                            <td>".$row['status']."</td>
                            <td>
                            <a href ='#'>
                                <img src = 'icons/search.png' width='20'>
                            </a>
                            <a href ='#'>
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