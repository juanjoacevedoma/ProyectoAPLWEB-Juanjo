<?php
/**
 * Inicia la sesión de forma segura si no está iniciada
 */
function start_secure_session() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Iniciar sesión automáticamente al cargar funciones
start_secure_session();

/**
 * Comprueba si el usuario está autenticado
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Redirige al login si no está autenticado
 */
function require_auth() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Obtiene los datos del usuario logueado
 */
function get_logged_user() {
    return $_SESSION['user_nombre'] ?? 'Invitado';
}

/**
 * Establece un mensaje de alerta en la sesión
 */
function set_alert($message, $type = 'success') {
    $_SESSION['alert'] = [
        'message' => $message,
        'type' => $type
    ];
}
// ... (resto de funciones existentes)

/**
 * Obtiene y limpia la alerta de la sesión
 */
function get_alert() {
    start_secure_session();
    if (isset($_SESSION['alert'])) {
        $alert = $_SESSION['alert'];
        unset($_SESSION['alert']);
        return $alert;
    }
    return null;
}

/**
 * Valida que los campos obligatorios no estén vacíos
 * @param array $data El array $_POST u otro
 * @param array $fields Lista de campos a verificar
 * @return bool
 */
function validate_required($data, $fields) {
    foreach ($fields as $field) {
        if (!isset($data[$field]) || empty(trim($data[$field]))) {
            return false;
        }
    }
    return true;
}

/**
 * Formatea precio a moneda local
 */
function format_price($price) {
    return number_format($price, 2, ',', '.') . ' €';
}
?>
