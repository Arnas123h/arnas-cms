<?php
require_once __DIR__ . '/auth.php';


if (is_logged_in()) { header('Location: index.php'); exit; }

$klaida = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vartotojas  = trim($_POST['vartotojas'] ?? '');
    $slaptazodis = $_POST['slaptazodis'] ?? '';

    $st = db()->prepare("SELECT * FROM vartotojai WHERE vartotojas = ?");
    $st->execute([$vartotojas]);
    $u = $st->fetch();

    if ($u && password_verify($slaptazodis, $u['slaptazodis'])) {
        
        session_regenerate_id(true);
        $_SESSION['admin_id']   = $u['id'];
        $_SESSION['admin_name'] = $u['vartotojas'];
        header('Location: index.php');
        exit;
    } else {
        $klaida = 'Neteisingas prisijungimo vardas arba slaptažodis.';
    }
}
?>
<!doctype html>
<html lang="lt">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Prisijungimas – Admin</title>
  <link rel="stylesheet" href="admin.css" />
</head>
<body class="login-body">
  <form class="login-card" method="post" autocomplete="off">
    <h1>Admin prisijungimas</h1>
    <p class="sub">Arnas Video CMS</p>

    <?php if ($klaida): ?>
      <div class="alert alert--err"><?= htmlspecialchars($klaida, ENT_QUOTES) ?></div>
    <?php endif; ?>

    <label>Vartotojas</label>
    <input type="text" name="vartotojas" required autofocus />

    <label>Slaptažodis</label>
    <input type="password" name="slaptazodis" required />

    <button type="submit" class="btn-primary">Prisijungti</button>
    <a class="back-link" href="../index.php">← Atgal į svetainę</a>
  </form>
</body>
</html>
