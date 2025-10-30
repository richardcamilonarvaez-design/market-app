<?php
    // Step 1: get database access
    require('../config/database.php');

    // Step 2: get form data
    $c_name = trim($_POST['name']);
    $c_abbrev = trim($_POST['abbrev']);
    $c_code = trim($_POST['code']);

    // Step 3: check if country already exists
    $check_country = "
        SELECT c.code
        FROM country c
        WHERE c.code = '$c_code'
        LIMIT 1
    ";
    $res_check = pg_query($conn_supa, $check_country);

    if (pg_num_rows($res_check) > 0) {
        echo "<script>alert('Country already exists');</script>";
        echo "<script>window.location.href = 'register_country.html';</script>";
    } else {
        // Step 4: insert new country
        $query = "
            INSERT INTO country (
                name,
                abbrev,
                code
            ) VALUES (
                '$c_name',
                '$c_abbrev',
                '$c_code'
            )
        ";

        // Step 5: execute query
        $res = pg_query($conn_supa, $query);

        // Step 6: validate result
        if ($res) {
            echo "<script>alert('Country registered successfully');</script>";
            header('refresh:0; url=regions.php');
        } else {
            echo "Something wrong";
        }
    }
?>
