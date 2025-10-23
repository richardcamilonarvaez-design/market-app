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
        $message = "⚠️ Completa todos los campos.";
    } else {
        // Revisar si el código ya existe
        $check_query = "SELECT code FROM regions WHERE code = $1 LIMIT 1";
        $res_check = pg_query_params($conn_supa, $check_query, [$code]);

        if ($res_check && pg_num_rows($res_check) > 0) {
            $message = "⚠️ La región con este código ya existe.";
        } else {
            // Insertar región con id_country
            $insert_query = "
                INSERT INTO regions (name, abbrev, code, status, id_country)
                VALUES ($1, $2, $3, $4, $5)
            ";
            $res = pg_query_params($conn_supa, $insert_query, [$name, $abbrev, $code, $status, $country_id]);

            if ($res) {
                echo "<script>
                        alert('Región registrada exitosamente');
                        window.location.href='cities.php';
                      </script>";
                exit;
            } else {
                $message = "❌ Error al registrar la región: " . pg_last_error($conn_supa);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Región</title>
</head>
<body bgcolor="C1DBD8">
    <center><h1>Registrar Región</h1></center>

    <?php if (!empty($message)): ?>
        <center><p style="color: blue; font-weight: bold;"><?php echo $message; ?></p></center>
    <?php endif; ?>

    <form action="regions.php" method="post">
        <table border="0" align="center">
            <tr><td><label>Nombre:</label></td></tr>
            <tr><td><input type="text" name="name" placeholder="Nombre" required></td></tr>

            <tr><td><label>Abreviatura:</label></td></tr>
            <tr><td><input type="text" name="abbrev" placeholder="Abreviatura" required></td></tr>

            <tr><td><label>Código:</label></td></tr>
            <tr><td><input type="text" name="code" placeholder="Código" required></td></tr>

            <tr><td><label>Estado:</label></td></tr>
            <tr><td>
                <select name="status" required>
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
                </select>
            </td></tr>

            <tr><td><label>País:</label></td></tr>
            <tr><td>
                <select name="country_id" required>
                    <option value="">Seleccione un país</option>
                    <?php
                    $sql = "SELECT id, name FROM country ORDER BY name";
                    $res = pg_query($conn_supa, $sql);
                    if ($res && pg_num_rows($res) > 0) {
                        while ($row = pg_fetch_assoc($res)) {
                            echo "<option value='" . htmlspecialchars($row['id']) . "'>" . htmlspecialchars($row['name']) . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay países disponibles</option>";
                    }
                    ?>
                </select>
            </td></tr>

            <tr><td style="text-align:center;">
                <button style="background-color:blue; color:white; padding:10px 20px; border:none; cursor:pointer;">
                    Registrar Región
                </button>
            </td></tr>
        </table>
    </form>
</body>
</html>


