<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Content-Type: application/json');

// Funkcja do sprawdzania statusu URL
function checkUrlStatus($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $statusCode;
}

// Sprawdź, czy URL został przesłany
if (isset($_GET['q'])) {
    $url = $_GET['q'];

    // Sprawdź, czy URL jest poprawny
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $statusCode = checkUrlStatus($url);

        if ($statusCode >= 200 && $statusCode < 300) {
            $response = ['status' => 'valid', 'code' => $statusCode];
        } elseif ($statusCode >= 300 && $statusCode < 400) {
            $response = ['status' => 'redirect', 'code' => $statusCode];
        } elseif ($statusCode >= 400 && $statusCode < 500) {
            $response = ['status' => 'client_error', 'code' => $statusCode];
        } elseif ($statusCode >= 500) {
            $response = ['status' => 'server_error', 'code' => $statusCode];
        } else {
            $response = ['status' => 'unknown', 'code' => $statusCode];
        }
    } else {
        $response = ['status' => 'invalid_url'];
    }
} else {
    $response = ['status' => 'missing_url'];
}

echo json_encode($response);
?>