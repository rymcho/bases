<?php
require 'index.php';

// Asegúrate de que la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $apellido_paterno = $_POST['apellido_paterno'];
    $apellido_materno = $_POST['apellido_materno'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];
    $email = $_POST['email'];
    $contraseña = password_hash($_POST['contraseña'], PASSWORD_BCRYPT); // Encriptar la contraseña
    $escuela_origen = $_POST['escuela_origen'];
    $curriculum = $_POST['curriculum'];

    try {
        $pdo->beginTransaction();

        // Revisa los nombres de los parámetros aquí
        $sql_usuario = "INSERT INTO usuarios (nombre, apellido_paterno, apellido_materno, direccion, telefono, fecha_nacimiento, email, contraseña, id_rol)
                        VALUES (:nombre, :apellido_paterno, :apellido_materno, :direccion, :telefono, :fecha_nacimiento, :email, :contraseña, :id_rol)";
        $stmt_usuario = $pdo->prepare($sql_usuario);
        $stmt_usuario->execute([
            ':nombre' => $nombre,
            ':apellido_paterno' => $apellido_paterno,
            ':apellido_materno' => $apellido_materno,
            ':direccion' => $direccion,
            ':telefono' => $telefono,
            ':fecha_nacimiento' => $fecha_nacimiento,
            ':email' => $email,
            ':contraseña' => $contraseña,
            ':id_rol' => 3 // Rol de maestro
        ]);

        $id_usuario = $pdo->lastInsertId();

        $sql_maestro = "INSERT INTO maestros (id_usuario, escuela_origen, curriculum)
                        VALUES (:id_usuario, :escuela_origen, :curriculum)";
        $stmt_maestro = $pdo->prepare($sql_maestro);
        $stmt_maestro->execute([
            ':id_usuario' => $id_usuario,
            ':escuela_origen' => $escuela_origen,
            ':curriculum' => $curriculum
        ]);

        $pdo->commit();
        echo "Maestro registrado exitosamente.";
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "Error al registrar el maestro: " . $e->getMessage();
    }
} else {
    echo "Solicitud inválida. Solo se permite el método POST.";
}
?>
