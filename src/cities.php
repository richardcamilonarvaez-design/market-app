<?php
// Step 1: get database access
require('../config/database.php');

// Step 2: check connection
if (!$conn_supa) {
    die("Connection failed to Supabase!");
} else {
    echo "<p style='color:green; text-align:center;'>Connection successfully!</p>";
}

$message = ''; // Para mensajes al usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Step 3: get and clean form data
    $name = trim($_POST['name'] ?? '');
    $abbrev = trim($_POST['abbrev'] ?? '');
    $code = trim($_POST['code'] ?? '');
    $status_input = trim($_POST['status'] ?? '');
    $region_id = isset($_POST['region_id']) ? intval($_POST['region_id']) : 0;

    // Convert status text to boolean
    $status = ($status_input === 'active') ? 'TRUE' : 'FALSE';

    // Step 4: validate required fields
    if (empty($name) || empty($abbrev) || empty($code) || $region_id <= 0) {
        $message = "⚠️ Please complete all fields.";
    } else {
        // Step 5: check if city code already exists
        $check_query = "SELECT code FROM city WHERE code = $1 LIMIT 1";
        $res_check = pg_query_params($conn_supa, $check_query, [$code]);

        if ($res_check && pg_num_rows($res_check) > 0) {
            $message = "⚠️ A city with this code already exists.";
        } else {
            // Step 6: insert city
            $insert_query = "
                INSERT INTO city (name, abbrev, code, status, id_region)
                VALUES ($1, $2, $3, $4, $5)
            ";
            $res = pg_query_params($conn_supa, $insert_query, [$name, $abbrev, $code, $status, $region_id]);

            if ($res) {
                echo "<script>
                        alert('City registered successfully');
                        window.location.href='cities.php';
                      </script>";
                exit;
            } else {
                $message = "❌ Error inserting city: " . pg_last_error($conn_supa);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Market - Register City</title>
</head>
<body bgcolor="C1DBD8">
    <center><h1>REGISTER CITY</h1></center>

    <?php if (!empty($message)) : ?>
        <center><p style="color: blue; font-weight: bold;"><?php echo $message; ?></p></center>
    <?php endif; ?>

    <form action="cities.php" method="post">
        <table border="0" align="center">
            <tr><td><label>Name:</label></td></tr>
            <tr><td><input type="text" name="name" placeholder="Name" required></td></tr>

            <tr><td><label>Abbrev:</label></td></tr>
            <tr><td><input type="text" name="abbrev" placeholder="Abbrev" required></td></tr>

            <tr><td><label>Code:</label></td></tr>
            <tr><td><input type="text" name="code" placeholder="Code" required></td></tr>

            <tr><td><label>Status:</label></td></tr>
            <tr><td>
                <select name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </td></tr>

            <tr><td><label>Region:</label></td></tr>
            <tr><td>
                <select name="region_id" required>
                    <option value="">Select a Region</option>
                    <?php
                    $sql = "SELECT id, name FROM regions ORDER BY name";
                    $res = pg_query($conn_supa, $sql);
                    if ($res && pg_num_rows($res) > 0) {
                        while ($row = pg_fetch_assoc($res)) {
                            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No regions found</option>";
                    }
                    ?>
                </select>
            </td></tr>

            <tr><td style="text-align:center;">
                <button style="background-color:blue; color:white; padding:10px 20px; border:none; cursor:pointer;">Register City</button>
            </td></tr>
        </table>
    </form>
</body>
</html>
