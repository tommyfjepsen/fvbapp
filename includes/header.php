<?php
require_once __DIR__ . '/../functions.php';

$activePage = isset($activePage) ? $activePage : '';
$sponsorName = current_sponsor_name();
$sponsorId = current_sponsor_id();

function avatar_initial($name)
{
    if (function_exists('mb_substr')) {
        return mb_substr($name, 0, 1);
    }
    return substr($name, 0, 1);
}

function nav_link($label, $href, $activePage)
{
    $activeClass = $activePage === $href ? 'class="active"' : '';
    echo '<a href="' . htmlspecialchars($href) . '" ' . $activeClass . '>' . htmlspecialchars($label) . '</a>';
}
?>
<!DOCTYPE html>
<html lang="da">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fyens Væddeløbsbane – Sponsornetværk</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        header { background: #fff; padding: 16px 24px; box-shadow: 0 2px 6px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between; }
        .brand { display: flex; align-items: center; }
        .brand-mark { height: 44px; width: 44px; margin-right: 12px; border-radius: 10px; background: linear-gradient(135deg, #f36f21, #f48f4f); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .nav { display: flex; gap: 16px; }
        .nav a { text-decoration: none; color: #333; padding: 8px 12px; border-radius: 6px; }
        .nav a.active { background: #f36f21; color: #fff; }
        .user-status { display: flex; align-items: center; gap: 10px; }
        .avatar { background: #f36f21; color: #fff; border-radius: 50%; width: 36px; height: 36px; display: flex; align-items: center; justify-content: center; font-weight: bold; }
        .content { max-width: 1100px; margin: 24px auto; padding: 0 16px; }
        .cards { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px; }
        .card { background: #fff; border-radius: 12px; box-shadow: 0 6px 20px rgba(0,0,0,0.08); overflow: hidden; position: relative; }
        .card img { width: 100%; height: 180px; object-fit: cover; }
        .card-content { padding: 16px 16px 24px; }
        .badge { position: absolute; top: 14px; left: 14px; background: rgba(0,0,0,0.75); color: #fff; padding: 6px 12px; border-radius: 999px; font-size: 12px; text-transform: uppercase; letter-spacing: 0.4px; }
        .card h3 { margin: 6px 0 8px; font-size: 18px; }
        .card .meta { color: #666; font-size: 14px; margin-bottom: 6px; }
        .card .description { color: #444; font-size: 14px; }
        .pill { position: absolute; right: 14px; bottom: 14px; width: 60px; height: 60px; border-radius: 50%; background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-weight: bold; color: #666; box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .pill.green { background: #e7f6ef; color: #1b7b3a; }
        .tabs { margin-top: 12px; display: flex; gap: 12px; }
        .tabs a { text-decoration: none; color: #555; padding: 8px 12px; border-radius: 8px; background: #f0f0f0; }
        .tabs a.active { background: #f36f21; color: #fff; }
        .login-link { text-decoration: none; color: #f36f21; font-weight: bold; }
        @media (max-width: 640px) {
            header { flex-direction: column; align-items: flex-start; gap: 12px; }
            .nav { width: 100%; flex-wrap: wrap; }
            .user-status { align-self: flex-end; }
            .card img { height: 160px; }
        }
    </style>
</head>
<body>
<header>
    <div class="brand">
        <div class="brand-mark">FVB</div>
        <div>
            <div style="font-weight:bold;">Fyens Væddeløbsbane</div>
            <div style="color:#555;">Sponsornetværk</div>
        </div>
    </div>
    <div class="nav">
        <?php nav_link('Arrangementer', 'index.php', $activePage); ?>
        <?php nav_link('Netværk', 'netvaerk.php', $activePage); ?>
        <?php nav_link('Rabatter', 'rabatter.php', $activePage); ?>
    </div>
    <div class="user-status">
        <?php if ($sponsorId): ?>
            <div class="avatar"><?php echo htmlspecialchars(avatar_initial($sponsorName)); ?></div>
            <div>
                <div style="font-size:13px;color:#666;">Logget ind som</div>
                <div style="font-weight:bold;"><?php echo htmlspecialchars($sponsorName); ?></div>
            </div>
            <a class="login-link" href="logout.php">Log ud</a>
        <?php else: ?>
            <a class="login-link" href="login.php">Log ind</a>
        <?php endif; ?>
    </div>
</header>
<div class="content">
    <div class="tabs">
        <a href="index.php" class="<?php echo $activePage === 'index.php' ? 'active' : ''; ?>">Arrangementer</a>
        <a href="netvaerk.php" class="<?php echo $activePage === 'netvaerk.php' ? 'active' : ''; ?>">Netværk</a>
        <a href="rabatter.php" class="<?php echo $activePage === 'rabatter.php' ? 'active' : ''; ?>">Rabatter</a>
    </div>
