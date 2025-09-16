<?php

// Configura la respuesta como JSON
header('Content-Type: application/json; charset=utf-8');

// Incluye la configuración
require_once __DIR__ . '/../config/config.php';

/**
 * Obtiene la entrada JSON enviada al endpoint
 */
function getInput() {
    $input = json_decode(file_get_contents('php://input'), true);
    return is_array($input) ? $input : [];
}

/**
 * Construye los parámetros permitidos para la consulta a la API Mobilia
 * Asegura que los obligatorios estén presentes y con formato correcto
 */
function buildParams($input) {
    if (!function_exists('mobilia_allowed_params')) {
        return [];
    }
    $allowed = mobilia_allowed_params();
    $params = [];

    // Parámetros obligatorios
    $params['operation'] = 'getMatchingProperties';
    $params['propertyTypeCode'] = isset($input['propertyTypeCode']) ? $input['propertyTypeCode'] : '';
    $params['sectorCode'] = isset($input['sectorCode']) ? $input['sectorCode'] : '';
    $params['forRent'] = (isset($input['forRent']) && in_array($input['forRent'], ['T','F'])) ? $input['forRent'] : 'T';
    $params['onSale']  = (isset($input['onSale'])  && in_array($input['onSale'],  ['T','F'])) ? $input['onSale']  : 'F';

    // Parámetros opcionales
    foreach ($allowed as $key) {
        if (!isset($params[$key]) && isset($input[$key]) && $input[$key] !== '') {
            $params[$key] = $input[$key];
        }
    }

    // Validación: solo propertyTypeCode es obligatorio
    if ($params['propertyTypeCode'] === '') {
        http_response_code(400);
        echo json_encode(['error'=>'Falta parámetro obligatorio: propertyTypeCode']);
        exit;
    }

    return $params;
}

/**
 * Realiza la consulta a la API Mobilia usando cURL
 */
function callMobiliaApi($params) {
    global $apiKey;
    if (!defined('MOBILIA_BASE_URL') || !$apiKey) {
        return [null, 500, 'Configuración de Mobilia no definida', ''];
    }
    // Agregar la key en la URL
    $params['key'] = $apiKey;
    $url = MOBILIA_BASE_URL . '?' . http_build_query($params);
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 25,
    ]);
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    curl_close($ch);
    return [$response, $httpCode, $error, $url];
}

// --- BLOQUE PRINCIPAL ---

$input = getInput(); // Entrada del usuario

// Permitir que la API Key se tome del payload si está presente
// --- CAMBIO: Ahora la API Key puede venir en el payload (enviado desde el frontend) o desde config.php.
// Esto permite pruebas flexibles y facilita el diagnóstico de problemas de autenticación.
// En producción, lo ideal es usar solo la clave del backend y nunca exponerla en el frontend.
    // --- CAMBIO: Se agrega la API Key como parámetro 'key' en la URL de la petición externa.
    // Algunos servicios requieren la clave en la query string y no solo en la cabecera.
    // Por seguridad, en producción se recomienda usar solo la cabecera si el servicio lo permite.
$apiKey = (isset($input['apiKey']) && $input['apiKey'] !== '') ? $input['apiKey'] : 'b337103d-34e9-4ea6-8b80-21b86592532d';
if (!$apiKey) {
    http_response_code(401);
    echo json_encode([
        'error'=>'API Key no configurada en backend (apiKey)',
        'api_key'=> $apiKey,
        'config_path'=> __DIR__ . '/../config/config.php'
    ]);
    exit;
}

$params = buildParams($input); // Construye los parámetros
list($out, $http, $err, $url) = callMobiliaApi($params); // Llama a la API

// Manejo de errores en la respuesta
if ($err || $http >= 400) {
    http_response_code($http ?: 502);
    echo json_encode([
        'error'  => 'Error consultando servicio',
        'detail' => $err,
        'http'   => $http,
        'url'    => $url,
        'api_key'=> MOBILIA_API_KEY,
        'config_path'=> __DIR__ . '/../config/config.php'
    ]);
    exit;
}

// Respuesta exitosa
http_response_code($http ?: 200);
echo $out ?: json_encode(['error'=>'Sin respuesta del servicio']);