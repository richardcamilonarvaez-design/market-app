<?php
require('../config/database.php'); // Conexión a Supabase

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibir datos del formulario
    $name = trim($_POST['name']);
    $abbrev = trim($_POST['abbrev']);
    $code = trim($_POST['code']);
    $status_input = trim($_POST['status']);
    $country_id = intval($_POST['country_id']); // del combo box

    // Convertir status a boolean
    $status = ($status_input === 'active') ? 'TRUE' : 'FALSE';

    // Validar campos obligatorios
    if (empty($name) || empty($abbrev) || empty($code) || $country_id <= 0) {
        $message = "Please complete all fields.";
    } else {
        // Revisar si el código ya existe
        $check_query = "SELECT code FROM regions WHERE code = $1 LIMIT 1";
        $res_check = pg_query_params($conn_supa, $check_query, [$code]);

        if ($res_check && pg_num_rows($res_check) > 0) {
            $message = "A region with this code already exists.";
        } else {
            // Insertar región con id_country
            $insert_query = "
                INSERT INTO regions (name, abbrev, code, status, id_country)
                VALUES ($1, $2, $3, $4, $5)
            ";
            $res = pg_query_params($conn_supa, $insert_query, [$name, $abbrev, $code, $status, $country_id]);

            if ($res) {
                echo "<script>
                        alert('Region registered successfully!');
                        window.location.href='cities.php';
                      </script>";
                exit;
            } else {
                $message = "Error registering region: " . pg_last_error($conn_supa);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Region</title>
</head>
<body bgcolor="#C1DBD8">
    <center><h1>REGISTER REGION</h1></center>

    <?php if (!empty($message)): ?>
        <center><p style="color: blue; font-weight: bold;"><?php echo htmlspecialchars($message); ?></p></center>
    <?php endif; ?>

    <form action="regions.php" method="post">
        <table border="0" align="center">
            <tr><td><label>Name:</label></td></tr>
            <tr><td><input type="text" name="name" placeholder="Name" required></td></tr>

            <tr><td><label>Abbreviation:</label></td></tr>
            <tr><td><input type="text" name="abbrev" placeholder="Abbreviation" required></td></tr>

            <tr><td><label>Code:</label></td></tr>
            <tr><td><input type="text" name="code" placeholder="Code" required></td></tr>

            <tr><td><label>Status:</label></td></tr>
            <tr><td>
                <select name="status" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
            </td></tr>

            <tr><td><label>Country:</label></td></tr>
            <tr><td>
                <select name="country_id" required>
                    <option value="">Select a country</option>
                    <?php
                    $sql = "SELECT id, name FROM country ORDER BY name";
                    $res = pg_query($conn_supa, $sql);
                    if ($res && pg_num_rows($res) > 0) {
                        while ($row = pg_fetch_assoc($res)) {
                            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No countries available</option>";
                    }
                    ?>
                </select>
            </td></tr>

            <tr><td style="text-align:center;">
                <button style="background-color:blue; color:white; padding:10px 20px; border:none; cursor:pointer;">
                    Register Region
                </button>
            </td></tr>
        </table>
    </form>
</body>
</html>
