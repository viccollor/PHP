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
        echo json_encode(['media' => $resultado[0]['media']]);
      } else {
        echo json_encode(['error' => 'No hay datos']);
      }
    } else {
      $sql = "SELECT * FROM notas";
      $con_bd = @conexion_bd(SERVIDOR, USER, PASSWD, BASE_DATOS, $sql);
      echo json_encode($con_bd, true);
    }
    break;


  case 'DELETE':
    if (isset($_REQUEST['dni'])) {
      $dni = filter_input(INPUT_GET, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
      $sql = "DELETE FROM notas WHERE dni = '" . $dni . "'";
      $con_bd = @conexion_bd(SERVIDOR, USER, PASSWD, BASE_DATOS, $sql);
      echo json_encode($con_bd, true);
    }
    break;

  case 'POST':
    $dni = filter_input(INPUT_POST, 'dni', FILTER_SANITIZE_SPECIAL_CHARS);
    $nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
    $grupo = filter_input(INPUT_POST, 'grupo', FILTER_SANITIZE_SPECIAL_CHARS);
    $fecha_hora = filter_input(INPUT_POST, 'fecha_hora');
    $asignatura = filter_input(INPUT_POST, 'asignatura', FILTER_SANITIZE_SPECIAL_CHARS);
    $nota = filter_input(INPUT_POST, 'nota', FILTER_VALIDATE_FLOAT);

    $sql = "INSERT INTO notas (dni, nombre, grupo, fecha_hora, asignatura, nota)
              VALUES ('$dni', '$nombre', '$grupo', '$fecha_hora', '$asignatura', '$nota')";

    $con_bd = @conexion_bd(SERVIDOR, USER, PASSWD, BASE_DATOS, $sql);
    echo json_encode($con_bd, true);
    break;
}
