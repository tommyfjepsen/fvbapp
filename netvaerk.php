<?php
$activePage = 'netvaerk.php';
require_once __DIR__ . '/includes/header.php';

$conn = get_db_connection();
$sponsors = array();
$error = '';

if ($conn->connect_errno) {
    $error = 'Kunne ikke forbinde til databasen: ' . htmlspecialchars($conn->connect_error);
} else {
    $sql = "SELECT company_name, contact_name, email, phone, level FROM sponsors WHERE active = 1 ORDER BY company_name";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $sponsors[] = $row;
        }
    } else {
        $error = 'Der opstod en fejl under hentning af sponsorer.';
    }
}
?>

<h1>Netværk</h1>
<?php if ($error): ?>
    <p style="color:#c00; font-weight:bold;"><?php echo $error; ?></p>
<?php endif; ?>
<div class="cards">
<?php foreach ($sponsors as $sponsor): ?>
    <div class="card">
        <div class="card-content">
            <h3><?php echo htmlspecialchars($sponsor['company_name']); ?></h3>
            <?php if (!empty($sponsor['level'])): ?>
                <div class="badge" style="position:static; display:inline-block; margin-top:4px; background:#f36f21;"><?php echo htmlspecialchars($sponsor['level']); ?></div>
            <?php endif; ?>
            <div class="meta">Kontakt: <?php echo htmlspecialchars($sponsor['contact_name']); ?></div>
            <div class="meta">Mail: <a class="login-link" href="mailto:<?php echo htmlspecialchars($sponsor['email']); ?>"><?php echo htmlspecialchars($sponsor['email']); ?></a></div>
            <div class="meta">Telefon: <a class="login-link" href="tel:<?php echo htmlspecialchars($sponsor['phone']); ?>"><?php echo htmlspecialchars($sponsor['phone']); ?></a></div>
        </div>
    </div>
<?php endforeach; ?>
<?php if (!$sponsors && !$error): ?>
    <p>Ingen sponsorer fundet.</p>
<?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
