<?php
/* Función para la conexión a una BD */
function conexion_bd($serv, $user, $passwd, $bd, $sql): array|string
{
    $con_bd = mysqli_connect($serv, $user, $passwd, $bd);
    if ($con_bd) {
        if ($res = mysqli_query($con_bd, $sql)) {
            $operacion = explode(' ', $sql);
            switch (strtoupper($operacion[0])) { // Distingue la operación SQL
                case "SELECT":
                    if (mysqli_num_rows($res) >= 1) {
                        $res_array = mysqli_fetch_all($res, MYSQLI_ASSOC); // Más legible
                    } else {
                        $res_array = "No se encontraron resultados en la BD";
                    }
                    break;
                case "INSERT":
                case "UPDATE":
                case "DELETE":
                    if (mysqli_affected_rows($con_bd) > 0) {
                        $res_array = "Operación realizada en la BD";
                    } else {
                        $res_array = "No se realizaron cambios en la BD";
                    }
                    break;
                default:
                    $res_array = "Operación SQL no soportada";
            }
            mysqli_free_result($res); // Liberar resultados
        } else {
            $res_array = "Error en la consulta SQL: " . mysqli_error($con_bd);
        }
        mysqli_close($con_bd); // Cierra la conexión
    } else {
        $res_array = "Error al conectar con la BD: " . mysqli_connect_error();
    }
    return $res_array;
}

