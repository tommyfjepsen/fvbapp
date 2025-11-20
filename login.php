<?php
$activePage = '';
require_once __DIR__ . '/includes/header.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if ($email === '' || $password === '') {
        $error = 'Udfyld både email og password.';
    } else {
        $sponsor = find_sponsor_by_email($email);
        if ($sponsor) {
            $valid = false;
            if (!empty($sponsor['password'])) {
                // Support hashed passwords when muligt, otherwise fallback to plain text comparison.
                $valid = password_verify($password, $sponsor['password']) || $sponsor['password'] === $password;
            }
            if ($valid) {
                $_SESSION['sponsor_id'] = $sponsor['id'];
                $_SESSION['sponsor_name'] = $sponsor['name'];
                header('Location: index.php');
                exit;
            }
        }
        $error = 'Login mislykkedes. Kontroller dine oplysninger.';
    }
}
?>

<h1>Login</h1>
<?php if ($error): ?>
    <p style="color:#c00; font-weight:bold;"><?php echo $error; ?></p>
<?php endif; ?>
<form method="post" style="max-width:420px; background:#fff; padding:20px; border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,0.08);">
    <div style="margin-bottom:12px;">
        <label for="email" style="display:block; font-weight:bold; margin-bottom:6px;">Email</label>
        <input type="email" id="email" name="email" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:8px;">
    </div>
    <div style="margin-bottom:16px;">
        <label for="password" style="display:block; font-weight:bold; margin-bottom:6px;">Adgangskode</label>
        <input type="password" id="password" name="password" required style="width:100%; padding:10px; border:1px solid #ccc; border-radius:8px;">
    </div>
    <button type="submit" style="background:#f36f21; color:#fff; border:none; padding:12px 18px; border-radius:8px; font-weight:bold; cursor:pointer;">Log ind</button>
</form>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
