<?php $page='darbai'; $title='Darbai'; require __DIR__ . '/header.php';
$darbai = get_darbai();
$ok = $_GET['ok'] ?? '';
?>

  <div class="bar">
    <div>
      <h1 class="h">Darbai</h1>
      <p class="muted">Iš viso: <?= count($darbai) ?></p>
    </div>
    <a class="btn btn--main" href="darbas-forma.php">+ Pridėti darbą</a>
  </div>

  <?php if ($ok === 'pridetas'): ?><div class="alert alert--ok">Darbas pridėtas.</div><?php endif; ?>
  <?php if ($ok === 'atnaujintas'): ?><div class="alert alert--ok">Darbas atnaujintas.</div><?php endif; ?>
  <?php if ($ok === 'istrintas'): ?><div class="alert alert--ok">Darbas ištrintas.</div><?php endif; ?>

  <table class="list">
    <thead>
      <tr>
        <th>Nuotrauka</th>
        <th>Pavadinimas</th>
        <th>Formatas</th>
        <th>Kategorija</th>
        <th>Trukmė</th>
        <th>Veiksmai</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($darbai as $d):
        $img = $d['nuotrauka'] ? '../' . $d['nuotrauka'] : yt_thumb($d['nuoroda']);
      ?>
      <tr>
        <td>
          <?php if ($img): ?><img src="<?= h($img) ?>" alt=""><?php else: ?><span class="muted">—</span><?php endif; ?>
        </td>
        <td><?= h($d['pavadinimas']) ?></td>
        <td><?= h($d['formatas']) ?></td>
        <td><?= h($d['kategorija']) ?></td>
        <td><?= h($d['trukme']) ?></td>
        <td>
          <div class="actions">
            <a class="btn btn--sm" href="darbas-forma.php?id=<?= (int)$d['id'] ?>">Redaguoti</a>
            <form method="post" action="darbas-trinti.php" onsubmit="return confirm('Ištrinti šį darbą?');" style="margin:0;">
              <input type="hidden" name="id" value="<?= (int)$d['id'] ?>">
              <button type="submit" class="btn btn--sm btn--danger">Trinti</button>
            </form>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>

      <?php if (!$darbai): ?>
        <tr><td colspan="6" class="muted">Darbų dar nėra. Spausk „Pridėti darbą".</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

<?php require __DIR__ . '/footer.php'; ?>
