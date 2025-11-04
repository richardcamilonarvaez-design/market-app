<?php
    session_start();

    if(isset($_SESSION['session_user_id'])){
        header('refresh:0;url=main.php');
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
    <center><h6><b><?php echo $_SESSION['session_user_fullname'];?></b>Here print your name</h6></center>
    <a href="list_users.php">List all users</a>|
    <a href="logout.php">Logout</a>
</body>
</html>