<?php
    //Step 1: get database acces
    require('../config/database.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marketapp - List users</title>
</head>
<body>
    <table border= "1" align="center">
        <tr>
            <th>Fullname</th>
            <th>E-mail</th>
            <th>Id. number</th>
            <th>Phone number</th>
            <th>Status</th>
            <th>Options</th>
        </tr>
        <?php
            sql_users = "
            
            ";
        ?>
        <tr>
            <td>Joe Doe</td>
            <td>joe@mail.com</td>
            <td>1085963852</td>
            <td>3005635263</td>
            <td>Active</td>
            <td>
                <a href="#"><img src= "icons/search.png" width="20"></a>
                <a href="#"><img src= "icons/refresh.png" width="20"></a>
                <a href="#"><img src= "icons/delete.png" width="20"></a>
            </td>
        </tr>
    </table>
</body>
</html>