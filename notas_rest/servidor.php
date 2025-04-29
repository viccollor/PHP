<?php
include 'conexion_bd.php';
include 'datos_conexion_bd.php';

$metodo = $_SERVER['REQUEST_METHOD'];
$recurso = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);

switch ($metodo) {

  case 'GET':
    if (isset($_GET['dni']) && isset($_GET['asignatura'])) {
      $dni = filter_input(INPUT_GET, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
      $asignatura = filter_input(INPUT_GET, 'asignatura', FILTER_SANITIZE_SPECIAL_CHARS);

      $sql = "SELECT AVG(nota) AS media FROM notas WHERE dni = '$dni' AND asignatura = '$asignatura'";
      $resultado = @conexion_bd(SERVIDOR, USER, PASSWD, BASE_DATOS, $sql);
      
      if (is_array($resultado) && count($resultado) > 0) {
        echo json_encode(['media' => round($resultado[0][0], 1)]);
      } else {
        echo json_encode(['error' => 'No hay notas para calcular la media.']);
      }
    } else {
      $sql = "SELECT * FROM notas";
      $con_bd = @conexion_bd(SERVIDOR, USER, PASSWD, BASE_DATOS, $sql);
      echo json_encode($con_bd, true);
    }
    break;

  case 'POST':
    // Obtener datos directamente del POST
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $grupo = $_POST['grupo'];
    $fecha_hora = $_POST['fecha_hora'];
    $asignatura = $_POST['asignatura'];
    $nota = $_POST['nota'];

    $sql = "INSERT INTO notas (dni, nombre, grupo, fecha_hora, asignatura, nota)
            VALUES ('$dni', '$nombre', '$grupo', '$fecha_hora', '$asignatura', $nota)";
    
    // Ejecutar consulta
    $exito = conexion_bd(SERVIDOR, USER, PASSWD, BASE_DATOS, $sql);
    
    // Devolver respuesta estructurada
    echo json_encode([
        'exito' => $exito,
        'nota' => $nota
    ]);
    break;

  case 'PUT':
    parse_str(file_get_contents("php://input"), $datos_put);
    $dni = filter_var($datos_put['dni'], FILTER_SANITIZE_SPECIAL_CHARS);
    $asignatura = filter_var($datos_put['asignatura'], FILTER_SANITIZE_SPECIAL_CHARS);
    $nota = filter_var($datos_put['nota'], FILTER_VALIDATE_FLOAT);

    if ($dni && $asignatura && $nota !== false) {
      $sql = "UPDATE notas SET nota = $nota WHERE dni = '$dni' AND asignatura = '$asignatura'";
      $exito = conexion_bd(SERVIDOR, USER, PASSWD, BASE_DATOS, $sql);

      echo json_encode([
          'exito' => $exito,
          'mensaje' => $exito ? 'Nota actualizada correctamente.' : 'Error al actualizar la nota.'
      ]);
    } else {
      echo json_encode(['error' => 'Datos inválidos para la actualización.']);
    }
    break;

  case 'DELETE':
    $dni = filter_input(INPUT_GET, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
    $asignatura = filter_input(INPUT_GET, 'asignatura', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($dni && $asignatura) {
      $sql = "DELETE FROM notas WHERE dni = '$dni' AND asignatura = '$asignatura'";
      $exito = conexion_bd(SERVIDOR, USER, PASSWD, BASE_DATOS, $sql);

      echo json_encode([
          'exito' => $exito,
          'mensaje' => $exito ? 'Registro eliminado correctamente.' : 'Error al eliminar el registro.'
      ]);
    } else {
      echo json_encode(['error' => 'DNI y asignatura son obligatorios.']);
    }
    break;

  default:
    echo json_encode(['error' => 'Método HTTP no permitido.']);
    break;
}