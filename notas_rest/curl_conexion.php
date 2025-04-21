<?php

/**
 * Función de conexión mediante cURL con servidores REST
 * Toma la $url y el método (GET, POST, PUT o DELETE)
 * y opcionalmente parámetros para el envío tipo POST/PUT.
 */
function curl_conexion($url, $metodo, $params = null)
{
    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $metodo);

    // En caso de que existan parámetros, los enviamos por POSTFIELDS
    if ($params != null) {
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, array("Cache-Control: no-cache"));

    // Ejecuta la llamada al servidor y obtiene la respuesta
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    // Si hubo error en la conexión, se retorna un mensaje JSON con el error
    if ($err) {
        $response = json_encode("cURL Error #:" . $err);
    }

    return $response;
}