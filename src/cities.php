<?php
// Step 1: get database access
require('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 2: get and clean form data
    $name = trim($_POST['name']);
    $abbrev = trim($_POST['abbrev']);
    $code = trim($_POST['code']);
    $status_input = trim($_POST['status']);

    // Convert status text to boolean for DB
    $status = ($status_input === 'active') ? 'TRUE' : 'FALSE';

    // Step 3: check if region with this code already exists
    $check_region = "
        SELECT code
        FROM region
        WHERE code = '$code'
        LIMIT 1
    ";
    $res_check = pg_query($conn_supa, $check_region);

    if (pg_num_rows($res_check) > 0) {
        echo "<script>alert('Region with this code already exists');</script>";
        header('refresh:0; url=regions.php');
        exit;
    } else {
        // Step 4: insert new region
        $query = "
            INSERT INTO region (name, abbrev, code, status)
            VALUES ('$name', '$abbrev', '$code', $status)
        ";

        $res = pg_query($conn_supa, $query);

        if ($res) {
            echo "<script>alert('Region registered successfully');</script>";
            header('refresh:0; url=cities.php'); // Cambia a donde quieras ir después
            exit;
        } else {
            echo "Something went wrong";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Market-Register Region</title>
    <link rel="icon" type="image/png" href="icons/market_main1.png" />
</head>
<body bgcolor="C1DBD8">
    <center><strong><h1>REGISTER REGION:</h1></strong></center>
    <form name="register-form" action="" method="post">
        <table border="0" align="center">
            <tr><td><label>Name: </label></td></tr>
            <tr><td><input type="text" name="name" placeholder="Name" required></td></tr>
            <tr><td><label>Abbrev: </label></td></tr>
            <tr><td><input type="text" name="abbrev" placeholder="Abbrev" required></td></tr>
            <tr><td><label>Code: </label></td></tr>
            <tr><td><input type="text" name="code" placeholder="Code" required></td></tr>
            <tr><td><label>Status: </label></td></tr>
            <tr><td>
                <select name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </td></tr>
            <tr><td style="text-align:center;">
                <button style="background-color: blue; color: white; border: none; padding: 10px 20px; cursor: pointer;">Register</button>
            </td></tr>
        </table>
    </form>
</body>
</html>
