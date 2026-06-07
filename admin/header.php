<?php

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();
$page  = $page  ?? '';
$title = $title ?? 'Admin';
?>
<!doctype html>
<html lang="lt">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($title, ENT_QUOTES) ?> – Admin</title>
  <link rel="stylesheet" href="admin.css" />
</head>
<body>
  <nav class="topnav">
    <span class="brand">Arnas Video · Admin</span>
    <span class="links">
      <a href="index.php"    class="<?= $page==='dash'?'active':'' ?>">Skydelis</a>
      <a href="darbai.php"   class="<?= $page==='darbai'?'active':'' ?>">Darbai</a>
      <a href="settings.php" class="<?= $page==='settings'?'active':'' ?>">Nustatymai</a>
      <a href="../index.php" target="_blank">Svetainė ↗</a>
      <a href="logout.php" class="out">Atsijungti</a>
    </span>
  </nav>
  <div class="wrap">
