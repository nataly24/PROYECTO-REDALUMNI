<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// CORS Headers
header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=UTF-8");

// Debug log
error_log("Request received at stats.php");
error_log("Request method: " . $_SERVER['REQUEST_METHOD']);

// Handle preflight OPTIONS request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

try {
    // Database connection
    $host = '127.0.0.1';
    $db   = 'proyectolaravelredalumni';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    // Create PDO connection
    $pdo = new PDO($dsn, $user, $pass, $options);
    error_log("Database connection successful");

    // Execute queries with error checking
    $queries = [
        'usuario' => "SELECT COUNT(*) FROM usuario",
        'empresa' => "SELECT COUNT(*) FROM empresa",
        'oferta_laboral' => "SELECT COUNT(*) FROM oferta_laboral",
        'exalumno' => "SELECT COUNT(*) FROM exalumno"
    ];

    $counts = [];
    foreach ($queries as $table => $query) {
        try {
            $counts[$table] = $pdo->query($query)->fetchColumn();
            error_log("Count for $table: " . $counts[$table]);
        } catch (PDOException $e) {
            error_log("Error querying $table: " . $e->getMessage());
            $counts[$table] = 0;
        }
    }

    // Create response array
    $response = [
        "totalUsuarios" => (int)$counts['usuario'],
        "empresasRegistradas" => (int)$counts['empresa'],
        "ofertasLaborales" => (int)$counts['oferta_laboral'],
        "exalumnosRegistrados" => (int)$counts['exalumno'],
        "notificaciones" => 7
    ];
    
    error_log("Sending response: " . json_encode($response));
    http_response_code(200);
    echo json_encode($response);
    
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        "mensaje" => "Error de base de datos",
        "error" => $e->getMessage()
    ]);
} catch (Exception $e) {
    error_log("General error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([
        "mensaje" => "Error al obtener estadísticas",
        "error" => $e->getMessage()
    ]);
}
?>