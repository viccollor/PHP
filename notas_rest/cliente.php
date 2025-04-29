<?php

include 'conexion_bd.php';
include 'curl_conexion.php';
include 'datos_conexion_bd.php';

// Función para insertar una nueva nota
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

      if ($respuesta === false) {
        echo "Error de conexión";
      } else {
        $resultado = json_decode($respuesta, true);

        if (json_last_error() === JSON_ERROR_NONE) {
          if (isset($resultado['exito']) && $resultado['exito']) {
            echo "Nota insertada: " . $resultado['nota'];
          } else {
            echo "Error del servidor: " . ($resultado['error'] ?? 'Desconocido');
          }
        } else {
          echo "Respuesta inválida: " . htmlspecialchars($respuesta);
        }
      }

    } else {
      echo "Todos los campos son obligatorios y la nota debe ser un número.";
    }
  }
}

// Función para calcular la media de notas
if (isset($_REQUEST["media"])) {
  if (isset($_REQUEST["dni"])) {
    $dni = filter_input(INPUT_POST, "dni", FILTER_SANITIZE_SPECIAL_CHARS);
    $asignatura = filter_input(INPUT_POST, "asignatura", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($dni && $asignatura) {
      $url = _URL_SERVIDOR_ . "servidor.php?dni=" . $dni . "&asignatura=" . $asignatura;

      $respuesta = curl_conexion($url, "GET");
      $resultado = json_decode($respuesta, true);
      
      if (is_array($resultado) && isset($resultado['media'])) {
        echo "La media de las notas es: " . $resultado['media'];
      } else {
        echo "Error al visualizar las notas. <br>";
      }
    } else {
      echo "DNI y asignatura son obligatorios.";
    }
  }
}

// Función para modificar una nota
if (isset($_REQUEST["modificar"])) {
  if (isset($_REQUEST["dni"]) && isset($_REQUEST["asignatura"]) && isset($_REQUEST["nota"])) {
    $dni = filter_input(INPUT_POST, "dni", FILTER_SANITIZE_SPECIAL_CHARS);
    $asignatura = filter_input(INPUT_POST, "asignatura", FILTER_SANITIZE_SPECIAL_CHARS);
    $nota = filter_input(INPUT_POST, "nota", FILTER_VALIDATE_FLOAT);

    if ($dni && $asignatura && $nota !== false) {
      $datos = [
        'dni' => $dni,
        'asignatura' => $asignatura,
        'nota' => $nota
      ];

      $url = _URL_SERVIDOR_ . "servidor.php";

      $respuesta = curl_conexion($url, "PUT", $datos);

      if ($respuesta === false) {
        echo "Error de conexión";
      } else {
        $resultado = json_decode($respuesta, true);

        if (json_last_error() === JSON_ERROR_NONE) {
          if (isset($resultado['exito']) && $resultado['exito']) {
            echo "Nota modificada correctamente.";
          } else {
            echo "Error del servidor: " . ($resultado['error'] ?? 'Desconocido');
          }
        } else {
          echo "Respuesta inválida: " . htmlspecialchars($respuesta);
        }
      }
    } else {
      echo "DNI, asignatura y nota son obligatorios, y la nota debe ser un número.";
    }
  }
}

// Función para eliminar un registro
if (isset($_REQUEST["eliminar"])) {
  if (isset($_REQUEST["dni"]) && isset($_REQUEST["asignatura"])) {
    $dni = filter_input(INPUT_POST, "dni", FILTER_SANITIZE_SPECIAL_CHARS);
    $asignatura = filter_input(INPUT_POST, "asignatura", FILTER_SANITIZE_SPECIAL_CHARS);

    if ($dni && $asignatura) {
      $url = _URL_SERVIDOR_ . "servidor.php?dni=" . $dni . "&asignatura=" . $asignatura;

      $respuesta = curl_conexion($url, "DELETE");

      if ($respuesta === false) {
        echo "Error de conexión";
      } else {
        $resultado = json_decode($respuesta, true);

        if (json_last_error() === JSON_ERROR_NONE) {
          if (isset($resultado['exito']) && $resultado['exito']) {
            echo "Registro eliminado correctamente.";
          } else {
            echo "Error del servidor: " . ($resultado['error'] ?? 'Desconocido');
          }
        } else {
          echo "Respuesta inválida: " . htmlspecialchars($respuesta);
        }
      }
    } else {
      echo "DNI y asignatura son obligatorios.";
    }
  }
}

echo '<br><br><a href="index.php">Volver</a>';
