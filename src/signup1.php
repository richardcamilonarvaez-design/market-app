<?php
// Step 1: get database access
require('../config/database.php');

// Step 2: check Supabase connection
if (!$conn_supa) {
    echo "<p style='color:red; text-align:center;'>❌ Connection failed!</p>";
    exit;
} else {
    echo "<p style='color:green; text-align:center;'>Connection successfully!</p>";
}

// Step 3: Fetch city data from Supabase
$query = "SELECT id, name, code FROM city ORDER BY name ASC";
$result = pg_query($conn_supa, $query);

$cities = [];

if ($result && pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        $cities[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Market - Register User</title>
</head>
<body bgcolor="#C1DBD8">
    <center><h1>REGISTER USER</h1></center>

    <form action="signup1.php" method="post">
        <table border="0" align="center">
            <tr><td><label>First Name:</label></td></tr>
            <tr><td><input type="text" name="firstname" placeholder="Firstname" required></td></tr>

            <tr><td><label>Last Name:</label></td></tr>
            <tr><td><input type="text" name="lastname" placeholder="Lastname" required></td></tr>

            <tr><td><label>Mobile Number:</label></td></tr>
            <tr><td><input type="text" name="mobile_number" placeholder="Mobile Number" required></td></tr>

            <tr><td><label>ID Number:</label></td></tr>
            <tr><td><input type="text" name="id_number" placeholder="ID Number" required></td></tr>

            <tr><td><label>Address:</label></td></tr>
            <tr><td><input type="text" name="address" placeholder="Address" required></td></tr>

            <tr><td><label>Email:</label></td></tr>
            <tr><td><input type="email" name="email" placeholder="Email" required></td></tr>

            <tr><td><label>Password:</label></td></tr>
            <tr><td><input type="password" name="password" placeholder="Password" required></td></tr>

            <tr><td><label>Status:</label></td></tr>
            <tr><td>
                <select name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </td></tr>
            <tr><td><label>Birth city:</label></td></tr>
            <tr><td>
                <select name="id_city_name" required>
                    <option value="">Select a City (Name)</option>
                    <?php
                    if (!empty($cities)) {
                        foreach ($cities as $city) {
                            echo "<option value='" . htmlspecialchars($city['id']) . "'>" .
                                 htmlspecialchars($city['name']) .
                                 "</option>";
                        }
                    } else {
                        echo "<option value=''>No cities found</option>";
                    }
                    ?>
                </select>
            </td></tr>
            <tr><td><label>Document city:</label></td></tr>
            <tr><td>
                <select name="id_city_code" required>
                    <option value="">Select a City (Code)</option>
                    <?php
                    if (!empty($cities)) {
                        foreach ($cities as $city) {
                            echo "<option value='" . htmlspecialchars($city['id']) . "'>" .
                                 htmlspecialchars($city['code']) .
                                 "</option>";
                        }
                    } else {
                        echo "<option value=''>No city codes found</option>";
                    }
                    ?>
                </select>
            </td></tr>

            <tr><td style="text-align:center;">
                <button style="background-color:blue; color:white; padding:10px 20px; border:none; cursor:pointer;">
                    Register
                </button>
            </td></tr>
        </table>
    </form>
</body>
</html>

