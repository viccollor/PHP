<?php

include 'conexion_bd.php';
include 'curl_conexion.php';
include 'datos_conexion_bd.php';

if (isset($_REQUEST["nueva"])) {
  if (isset($_REQUEST["dni"])) {
    $dni = filter_input(INPUT_POST, "dni", FILTER_SANITIZE_SPECIAL_CHARS);
    $nombre = filter_input(INPUT_POST, "nombre", FILTER_SANITIZE_SPECIAL_CHARS);
    $grupo = filter_input(INPUT_POST, "grupo", FILTER_SANITIZE_SPECIAL_CHARS);
    $fecha_hora = filter_input(INPUT_POST, "fecha_hora");
    $asignatura = filter_input(INPUT_POST, "asignatura", FILTER_SANITIZE_SPECIAL_CHARS);
    $nota = filter_input(INPUT_POST, "nota", FILTER_VALIDATE_FLOAT);

    if ($dni && $nombre && $grupo && $fecha_hora && $asignatura && $nota !== false) {

      $datos = [
        'dni' => $dni,
        'nombre' => $nombre,
        'grupo' => $grupo,
        'fecha_hora' => $fecha_hora,
        'asignatura' => $asignatura,
        'nota' => $nota
      ];

      $url = _URL_SERVIDOR_ . "servidor.php";
      $respuesta = curl_conexion($url, "POST", $datos);
      print_r($respuesta); // No muestra nada
      $resultado = json_decode($respuesta, true);

    } else {
      echo "Todos los campos son obligatorios y la nota debe ser un número.";
    }
  }
}
if (isset($_REQUEST["media"])) {
  if (isset($_REQUEST["dni"])) {
    $dni = filter_input(INPUT_POST, "dni", FILTER_SANITIZE_SPECIAL_CHARS);
    $asignatura = filter_input(INPUT_POST, "asignatura", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($dni && $asignatura) {
      $url = _URL_SERVIDOR_ . "servidor.php?dni=" . $dni . "&asignatura=" . $asignatura;

      $respuesta = curl_conexion($url, "GET");
      $resultado = json_decode($respuesta, true);

      if (is_array($resultado) && isset($resultado['media'])) {
        echo "La media de las notas es: " . round($resultado['media'], 1);
      } else {
        echo "Error al visualizar las notas. <br>";
      }
    } else {
      echo "DNI y asignatura son obligatorios.";
    }
  }
}
echo '<br><br><a href="index.php">Volver</a>';
