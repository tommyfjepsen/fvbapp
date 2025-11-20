<?php
$activePage = 'index.php';
require_once __DIR__ . '/includes/header.php';

$conn = get_db_connection();
$events = array();
$error = '';

if ($conn->connect_errno) {
    $error = 'Kunne ikke forbinde til databasen: ' . htmlspecialchars($conn->connect_error);
} else {
    $sql = "SELECT id, title, location, start_datetime, end_datetime, type, image_url, max_participants FROM events WHERE start_datetime >= NOW() ORDER BY start_datetime ASC";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
    } else {
        $error = 'Der opstod en fejl under hentning af arrangementer.';
    }
}
?>

<h1>Arrangementer</h1>
<?php if ($error): ?>
    <p style="color:#c00; font-weight:bold;"><?php echo $error; ?></p>
<?php endif; ?>
<div class="cards">
<?php foreach ($events as $event): ?>
    <?php
        $label = event_type_label(isset($event['type']) ? $event['type'] : '');
        $image = !empty($event['image_url']) ? $event['image_url'] : 'https://via.placeholder.com/600x300?text=Arrangement';
        $start = isset($event['start_datetime']) ? date('d.m.Y H:i', strtotime($event['start_datetime'])) : '';
        $end = isset($event['end_datetime']) ? date('H:i', strtotime($event['end_datetime'])) : '';
        $totals = fetch_registration_totals($event['id'], $sponsorId);
        $capacity = $totals['capacity'];
        $registered = $totals['user_count'];
        $pillText = $registered . ' / ' . ($capacity ? $capacity : '0');
        $pillClass = $registered > 0 ? 'pill green' : 'pill';
    ?>
    <div class="card">
        <span class="badge"><?php echo htmlspecialchars($label); ?></span>
        <img src="<?php echo htmlspecialchars($image); ?>" alt="Event billede">
        <div class="card-content">
            <h3><?php echo htmlspecialchars($event['title']); ?></h3>
            <div class="meta"><?php echo htmlspecialchars($event['location']); ?></div>
            <div class="meta"><?php echo htmlspecialchars($start); ?><?php echo $end ? ' – ' . htmlspecialchars($end) : ''; ?></div>
            <div class="description">
                <a class="login-link" href="event.php?id=<?php echo intval($event['id']); ?>">Se detaljer</a>
            </div>
            <div class="pill <?php echo $pillClass === 'pill green' ? 'green' : ''; ?>"><?php echo htmlspecialchars($pillText); ?></div>
        </div>
    </div>
<?php endforeach; ?>
<?php if (!$events && !$error): ?>
    <p>Der er ingen kommende arrangementer lige nu.</p>
<?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
