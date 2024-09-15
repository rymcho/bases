<?php
// procesar_registro_escuela.php
require 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre_escuela = $_POST['nombre_escuela'];
    $ubicacion = $_POST['ubicacion'];
    $nivel_escolar = $_POST['nivel_escolar'];

    try {
        // Consulta SQL para insertar la nueva escuela
        $sql = "INSERT INTO escuelas (nombre_escuela, ubicacion, nivel_escolar) VALUES (:nombre_escuela, :ubicacion, :nivel_escolar)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':nombre_escuela' => $nombre_escuela,
            ':ubicacion' => $ubicacion,
            ':nivel_escolar' => $nivel_escolar
        ]);

        echo "Escuela registrada exitosamente.";
    } catch (PDOException $e) {
        echo "Error al registrar la escuela: " . $e->getMessage();
    }
}
?>
