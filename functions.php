<?php
// Shared helper functions for the sponsor app (frontend and admin).
// Keep compatible with PHP 7.x only.

require_once __DIR__ . '/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Load email settings from a settings table.
 * Returns an associative array with defaults when rows are missing.
 */
function load_email_settings()
{
    $conn = get_db_connection();
    $defaults = array(
        'from_name' => 'Fyens Væddeløbsbane',
        'from_email' => 'noreply@example.com',
        'smtp_host' => '',
        'smtp_port' => 587,
        'smtp_user' => '',
        'smtp_password' => '',
        'smtp_encryption' => 'tls',
    );

    if ($conn->connect_errno) {
        return $defaults;
    }

    $sql = "SELECT setting_key, setting_value FROM settings WHERE setting_key LIKE 'smtp_%' OR setting_key IN ('from_name','from_email')";
    $result = $conn->query($sql);
    if (!$result) {
        return $defaults;
    }

    while ($row = $result->fetch_assoc()) {
        $defaults[$row['setting_key']] = $row['setting_value'];
    }
    return $defaults;
}

/**
 * Returns fallback reminder configuration.
 */
function get_default_reminders()
{
    return array(
        array('days_before' => 7, 'type' => 'reminder'),
        array('days_before' => 1, 'type' => 'reminder'),
    );
}

/**
 * Load generic settings in a key => value array.
 */
function load_settings()
{
    $conn = get_db_connection();
    $settings = array();
    if ($conn->connect_errno) {
        return $settings;
    }
    $sql = "SELECT setting_key, setting_value FROM settings";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $settings[$row['setting_key']] = $row['setting_value'];
        }
    }
    return $settings;
}

/**
 * Returns the logged-in sponsor id or null.
 */
function current_sponsor_id()
{
    return isset($_SESSION['sponsor_id']) ? intval($_SESSION['sponsor_id']) : null;
}

/**
 * Returns the logged-in sponsor name or empty string.
 */
function current_sponsor_name()
{
    return isset($_SESSION['sponsor_name']) ? $_SESSION['sponsor_name'] : '';
}

/**
 * Fetch sponsor by email for login.
 */
function find_sponsor_by_email($email)
{
    $conn = get_db_connection();
    if ($conn->connect_errno) {
        return null;
    }
    $stmt = $conn->prepare("SELECT id, name, email, password FROM sponsors WHERE email = ? AND active = 1");
    if (!$stmt) {
        return null;
    }
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $sponsor = $result ? $result->fetch_assoc() : null;
    $stmt->close();
    return $sponsor;
}

/**
 * Build a friendly label for event type.
 */
function event_type_label($type)
{
    $type = strtolower(trim($type));
    if ($type === 'vip') {
        return 'VIP-arrangement';
    }
    if ($type === 'netværk' || $type === 'netvaerk' || $type === 'network') {
        return 'Netværksarrangement';
    }
    return 'Arrangement';
}

/**
 * Get attendee counts per event for the logged in sponsor.
 */
function fetch_registration_totals($eventId, $sponsorId)
{
    $conn = get_db_connection();
    $totals = array('user_count' => 0, 'capacity' => 0, 'total_registered' => 0);
    if ($conn->connect_errno) {
        return $totals;
    }

    // Total registered across all sponsors
    $stmt = $conn->prepare("SELECT COALESCE(SUM(participants), 0) as total_registered FROM event_registrations WHERE event_id = ?");
    if ($stmt) {
        $stmt->bind_param('i', $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            $totals['total_registered'] = intval($row['total_registered']);
        }
        $stmt->close();
    }

    // Capacity on events table if present
    $capResult = $conn->query("SELECT max_participants FROM events WHERE id = " . intval($eventId));
    if ($capResult && ($row = $capResult->fetch_assoc())) {
        $totals['capacity'] = intval($row['max_participants']);
    }

    // Logged-in sponsor registration count
    if ($sponsorId) {
        $stmt = $conn->prepare("SELECT COALESCE(SUM(participants), 0) as user_count FROM event_registrations WHERE event_id = ? AND sponsor_id = ?");
        if ($stmt) {
            $stmt->bind_param('ii', $eventId, $sponsorId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result) {
                $row = $result->fetch_assoc();
                $totals['user_count'] = intval($row['user_count']);
            }
            $stmt->close();
        }
    }

    return $totals;
}

?>
