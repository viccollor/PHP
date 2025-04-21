<?php
$servidor = "localhost";
$usuario = "root";
$contrasena = "";
$base_datos = "notas_examenes";

// Crear conexión
$conexion = new mysqli($servidor, $usuario, $contrasena, $base_datos);

// Verificar conexión
if ($conexion->connect_error) {
    die("❌ Error de conexión: " . $conexion->connect_error);
}

// Datos a insertar
$dni = "12345678A";
$nombre = "Victor Pérez";
$grupo = "A1";
$fecha_hora = date("Y-m-d H:i:s"); // Fecha y hora actual
$asignatura = "Matemáticas";
$nota = 8.5;

// Preparar la consulta
$sql = "INSERT INTO notas (dni, nombre, grupo, fecha_hora, asignatura, nota)
        VALUES ('$dni', '$nombre', '$grupo', '$fecha_hora', '$asignatura', $nota)";

// Ejecutar la consulta
if ($conexion->query($sql) === TRUE) {
    echo "✅ Registro insertado correctamente";
} else {
    echo "❌ Error al insertar el registro: " . $conexion->error;
}

// Cerrar conexión
$conexion->close();
?>
