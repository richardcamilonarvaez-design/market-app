<?php
// Step 1: get database access
require('../config/database.php');

// Step 2: If form submitted, process insert
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $abbrev = trim($_POST['abbrev']);
    $code = trim($_POST['code']);
    $status_input = trim($_POST['status']);
    $country_code = trim($_POST['country_code']);  // el valor del combo box

    // Convertir status string a boolean para la DB
    $status = ($status_input === 'active') ? 'TRUE' : 'FALSE';

    // Puedes agregar validaciones aquí si quieres

    // Insertar nuevo region
    $query = "
        INSERT INTO region (name, abbrev, code, status, country_code)
        VALUES ('$name', '$abbrev', '$code', $status, '$country_code')
    ";

    $res = pg_query($conn_supa, $query);

    if ($res) {
        echo "<script>alert('Region registered successfully');</script>";
        header('refresh:0; url=regions.php');
        exit;
    } else {
        echo "Something went wrong with region insertion";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Register Region</title>
</head>
<body bgcolor="C1DBD8">
    <center><h1>Register Region</h1></center>
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

            <tr><td><label>Country:</label></td></tr>
            <tr><td>
                <select name="country_code" required>
                    <option value="">Select a Country</option>
                    <?php
                    // Cargar países para el combo box
                    $sql = "SELECT code, name FROM country ORDER BY name";
                    $res = pg_query($conn_supa, $sql);
                    if ($res && pg_num_rows($res) > 0) {
                        while ($row = pg_fetch_assoc($res)) {
                            echo "<option value='" . htmlspecialchars($row['code']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No countries found</option>";
                    }
                    ?>
                </select>
            </td></tr>

            <tr><td style="text-align:center;">
                <button style="background-color:blue; color:white; padding:10px 20px; border:none; cursor:pointer;">Register Region</button>
            </td></tr>
        </table>
    </form>
</body>
</html>

