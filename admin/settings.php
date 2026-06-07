<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$ok = false;
$klaida = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $values = $_POST['s'] ?? [];   


    [$logoKelias, $logoKlaida] = issaugoti_nuotrauka('logo_failas');
    if ($logoKlaida) {
        $klaida = $logoKlaida;
    } elseif ($logoKelias) {
        $values['logotipas'] = $logoKelias;
    }

    if (!$klaida) {
        
        $st = db()->prepare("UPDATE settings SET reiksme = ? WHERE raktas = ?");
        foreach ($values as $raktas => $reiksme) {
            $st->execute([trim((string)$reiksme), $raktas]);
        }
        $ok = true;
    }
}


$rows = db()->query("SELECT * FROM settings ORDER BY id")->fetchAll();

$page='settings'; $title='Nustatymai';
require __DIR__ . '/header.php';
?>

  <div class="bar">
    <div>
      <h1 class="h">Svetainės nustatymai</h1>
      <p class="muted">Galima tik redaguoti laukus. Naujų kurti / trinti negalima.</p>
    </div>
  </div>

  <?php if ($ok): ?><div class="alert alert--ok">Nustatymai išsaugoti.</div><?php endif; ?>
  <?php if ($klaida): ?><div class="alert alert--err"><?= h($klaida) ?></div><?php endif; ?>

  <form class="formcard" method="post" enctype="multipart/form-data">
    <?php foreach ($rows as $r):
      $raktas  = $r['raktas'];
      $reiksme = $r['reiksme'];
    ?>
      <div class="row">
        <label><?= h($r['etikete']) ?></label>

        <?php if ($raktas === 'apie'): ?>
          <textarea name="s[<?= h($raktas) ?>]"><?= h($reiksme) ?></textarea>

        <?php elseif ($raktas === 'logotipas'): ?>
          <input type="text" name="s[<?= h($raktas) ?>]" value="<?= h($reiksme) ?>">
          <p class="muted" style="margin:6px 0 0; font-size:13px;">Arba įkelk naują logotipą:</p>
          <input type="file" name="logo_failas" accept="image/*" style="margin-top:6px;">
          <?php if ($reiksme): ?><img class="preview" src="../<?= h($reiksme) ?>" alt="logo"><?php endif; ?>

        <?php else: ?>
          <input type="text" name="s[<?= h($raktas) ?>]" value="<?= h($reiksme) ?>">
        <?php endif; ?>
      </div>
    <?php endforeach; ?>

    <div class="formactions">
      <button type="submit" class="btn btn--main">Išsaugoti</button>
      <a class="btn" href="../index.php" target="_blank">Peržiūrėti svetainę ↗</a>
    </div>
  </form>

<?php require __DIR__ . '/footer.php'; ?>
