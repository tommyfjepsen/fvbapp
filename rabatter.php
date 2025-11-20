<?php
$activePage = 'rabatter.php';
require_once __DIR__ . '/includes/header.php';

$conn = get_db_connection();
$discounts = array();
$error = '';

if ($conn->connect_errno) {
    $error = 'Kunne ikke forbinde til databasen: ' . htmlspecialchars($conn->connect_error);
} else {
    $sql = "SELECT company_name, title, description, link, logo_path FROM discounts WHERE active = 1 ORDER BY company_name";
    $result = $conn->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $discounts[] = $row;
        }
    } else {
        $error = 'Der opstod en fejl under hentning af rabatter.';
    }
}
?>

<h1>Rabatter</h1>
<?php if ($error): ?>
    <p style="color:#c00; font-weight:bold;"><?php echo $error; ?></p>
<?php endif; ?>
<div class="cards">
<?php foreach ($discounts as $discount): ?>
    <div class="card" style="display:flex; align-items:center;">
        <div class="card-content" style="flex:1;">
            <h3><?php echo htmlspecialchars($discount['company_name']); ?></h3>
            <div class="meta" style="font-weight:bold;"><?php echo htmlspecialchars($discount['title']); ?></div>
            <div class="description"><?php echo nl2br(htmlspecialchars($discount['description'])); ?></div>
            <?php if (!empty($discount['link'])): ?>
                <div style="margin-top:8px;"><a class="login-link" target="_blank" rel="noopener" href="<?php echo htmlspecialchars($discount['link']); ?>">Besøg hjemmeside</a></div>
            <?php endif; ?>
        </div>
        <?php if (!empty($discount['logo_path'])): ?>
            <div style="padding: 0 16px 0 0; max-width: 160px;">
                <img src="<?php echo htmlspecialchars($discount['logo_path']); ?>" alt="<?php echo htmlspecialchars($discount['company_name']); ?> logo" style="max-width: 100%; height: auto;">
            </div>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
<?php if (!$discounts && !$error): ?>
    <p>Der er ingen rabatter tilgængelige.</p>
<?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
