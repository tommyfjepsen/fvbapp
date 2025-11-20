<?php
$activePage = 'index.php';
require_once __DIR__ . '/includes/header.php';

$conn = get_db_connection();
$event = null;
$error = '';
$eventId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($eventId <= 0) {
    $error = 'Ugyldigt arrangement.';
} elseif ($conn->connect_errno) {
    $error = 'Kunne ikke forbinde til databasen: ' . htmlspecialchars($conn->connect_error);
} else {
    $stmt = $conn->prepare("SELECT id, title, description, location, start_datetime, end_datetime, type, image_url, max_participants FROM events WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param('i', $eventId);
        $stmt->execute();
        $result = $stmt->get_result();
        $event = $result ? $result->fetch_assoc() : null;
        $stmt->close();
    }
    if (!$event) {
        $error = 'Arrangementet blev ikke fundet.';
    }
}
?>

<h1>Arrangement</h1>
<?php if ($error): ?>
    <p style="color:#c00; font-weight:bold;"><?php echo $error; ?></p>
<?php elseif ($event): ?>
    <?php
        $label = event_type_label(isset($event['type']) ? $event['type'] : '');
        $image = !empty($event['image_url']) ? $event['image_url'] : 'https://via.placeholder.com/600x300?text=Arrangement';
        $start = isset($event['start_datetime']) ? date('d.m.Y H:i', strtotime($event['start_datetime'])) : '';
        $end = isset($event['end_datetime']) ? date('H:i', strtotime($event['end_datetime'])) : '';
        $totals = fetch_registration_totals($event['id'], $sponsorId);
        $capacity = $totals['capacity'];
        $registered = $totals['user_count'];
    ?>
    <div class="card">
        <span class="badge"><?php echo htmlspecialchars($label); ?></span>
        <img src="<?php echo htmlspecialchars($image); ?>" alt="Event billede">
        <div class="card-content">
            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
            <div class="meta"><?php echo htmlspecialchars($event['location']); ?></div>
            <div class="meta"><?php echo htmlspecialchars($start); ?><?php echo $end ? ' – ' . htmlspecialchars($end) : ''; ?></div>
            <div class="description"><?php echo nl2br(htmlspecialchars($event['description'])); ?></div>
            <?php if ($capacity): ?>
                <div class="meta" style="margin-top:10px;">Din tilmelding: <?php echo intval($registered); ?> / <?php echo intval($capacity); ?> pladser</div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
