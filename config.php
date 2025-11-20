<?php
// Database configuration and connection helper shared across frontend and admin.
// Compatible with PHP 7.x.

// Allow a non-committed override so sensitive credentials can live in
// config.local.php on the server without touching the tracked file.
if (file_exists(__DIR__ . '/config.local.php')) {
    require_once __DIR__ . '/config.local.php';
}

// Update these constants to match the deployed database credentials (or set
// them inside config.local.php to avoid committing secrets).
if (!defined('DB_HOST')) {
    define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
}
if (!defined('DB_USER')) {
    define('DB_USER', getenv('DB_USER') ?: '');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', getenv('DB_PASS') ?: '');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', getenv('DB_NAME') ?: '');
}

// Shared mysqli connection instance. The connection is established on demand so
// includes can safely pull in this file without performing work during linting.
$GLOBALS['conn'] = isset($GLOBALS['conn']) ? $GLOBALS['conn'] : null;
// Backwards compatibility for legacy code that referenced $db or $mysqli.
$GLOBALS['db'] = isset($GLOBALS['db']) ? $GLOBALS['db'] : null;
$GLOBALS['mysqli'] = isset($GLOBALS['mysqli']) ? $GLOBALS['mysqli'] : null;

/**
 * Returns a mysqli connection that can be reused across the application.
 *
 * The function never returns null; on failure it returns a mysqli instance
 * carrying the error, allowing callers to check ->connect_errno before use.
 */
function get_db_connection()
{
    if ($GLOBALS['conn'] instanceof mysqli) {
        return $GLOBALS['conn'];
    }

    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($mysqli->connect_errno) {
        // Store the instance anyway so repeated attempts don't create loops.
        $GLOBALS['conn'] = $mysqli;
        $GLOBALS['db'] = $mysqli;
        $GLOBALS['mysqli'] = $mysqli;
        return $mysqli;
    }

    $mysqli->set_charset('utf8mb4');
    $GLOBALS['conn'] = $mysqli;
    $GLOBALS['db'] = $mysqli;
    $GLOBALS['mysqli'] = $mysqli;
    return $GLOBALS['conn'];
}

?>
