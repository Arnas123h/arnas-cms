<?php $page='dash'; $title='Skydelis'; require __DIR__ . '/header.php'; ?>

  <h1 class="h">Sveikas, <?= htmlspecialchars($_SESSION['admin_name'], ENT_QUOTES) ?>!</h1>
  <p class="muted">Valdyk savo svetainės turinį žemiau.</p>

  <div class="tiles">
    <a class="tile" href="darbai.php">
      <h3>🎬 Darbai</h3>
      <p>Pridėk, redaguok ar ištrink portfolio darbus (CRUD + nuotraukos).</p>
    </a>
    <a class="tile" href="settings.php">
      <h3>⚙️ Nustatymai</h3>
      <p>Keisk įmonės pavadinimą, logotipą, kontaktus, „Apie“ tekstą.</p>
    </a>
  </div>

<?php require __DIR__ . '/footer.php'; ?>
