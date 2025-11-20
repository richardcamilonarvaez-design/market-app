<?php
    session_start();

    if(!isset($_SESSION['session_user_id'])){
        header('refresh:0;url=error403.html');
    }

    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel ="icon" type="image/png" href="icons/market_main1.png">
    <title>Marketapp - Home</title>
</head>
<body bgcolor="cadffb">
    <table border= "0" align="center">
    <tr>
        <td><b>User: </b>
            <?php echo $_SESSION['session_user_fullname'];?>
        </td>
        <td>
            <!--<img src="<?//php echo $_SESSION['session_user_url_photo'] ?>" alt="User icon" class="user-icon" width='30'>-->
            <?php echo"<img src='".$_SESSION['session_user_url_photo']."'width='30'>";?>
        </td>
    </tr>
    </table>
    <a href="list_users.php">List all users</a>|
    <a href="logout.php">Logout</a>
</body>
</html>