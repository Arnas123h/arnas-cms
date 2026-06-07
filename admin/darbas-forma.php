<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

$id   = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$klaida = '';


$d = [
  'pavadinimas'=>'', 'trumpas'=>'', 'pilnas'=>'', 'nuotrauka'=>'',
  'formatas'=>'16x9', 'kategorija'=>'16x9', 'trukme'=>'', 'nuoroda'=>''
];
if ($id) {
    $rastas = get_darbas($id);
    if (!$rastas) { header('Location: darbai.php'); exit; }
    $d = $rastas;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $d['pavadinimas'] = trim($_POST['pavadinimas'] ?? '');
    $d['trumpas']     = trim($_POST['trumpas'] ?? '');
    $d['pilnas']      = trim($_POST['pilnas'] ?? '');
    $d['formatas']    = $_POST['formatas'] ?? '16x9';
    $d['kategorija']  = $_POST['kategorija'] ?? '16x9';
    $d['trukme']      = trim($_POST['trukme'] ?? '');
    $d['nuoroda']     = trim($_POST['nuoroda'] ?? '');

    if ($d['pavadinimas'] === '') {
        $klaida = 'Pavadinimas privalomas.';
    }

    
    $naujaNuotrauka = $d['nuotrauka'];
    if (!$klaida) {
        [$kelias, $upKlaida] = issaugoti_nuotrauka('nuotrauka');
        if ($upKlaida) {
            $klaida = $upKlaida;
        } elseif ($kelias) {
            
            if ($id && $d['nuotrauka']) trinti_nuotrauka($d['nuotrauka']);
            $naujaNuotrauka = $kelias;
        }
    }

    if (!$klaida) {
        if ($id) {
            $st = db()->prepare("UPDATE darbai SET pavadinimas=?, trumpas=?, pilnas=?, nuotrauka=?, formatas=?, kategorija=?, trukme=?, nuoroda=? WHERE id=?");
            $st->execute([$d['pavadinimas'],$d['trumpas'],$d['pilnas'],$naujaNuotrauka,$d['formatas'],$d['kategorija'],$d['trukme'],$d['nuoroda'],$id]);
            header('Location: darbai.php?ok=atnaujintas'); exit;
        } else {
            $st = db()->prepare("INSERT INTO darbai (pavadinimas,trumpas,pilnas,nuotrauka,formatas,kategorija,trukme,nuoroda) VALUES (?,?,?,?,?,?,?,?)");
            $st->execute([$d['pavadinimas'],$d['trumpas'],$d['pilnas'],$naujaNuotrauka,$d['formatas'],$d['kategorija'],$d['trukme'],$d['nuoroda']]);
            header('Location: darbai.php?ok=pridetas'); exit;
        }
    }
}

$title = $id ? 'Redaguoti darbą' : 'Pridėti darbą';
$page  = 'darbai';
require __DIR__ . '/header.php';
$peek = $d['nuotrauka'] ? '../' . $d['nuotrauka'] : yt_thumb($d['nuoroda']);
?>

  <div class="bar">
    <h1 class="h"><?= $id ? 'Redaguoti darbą' : 'Pridėti darbą' ?></h1>
    <a class="btn" href="darbai.php">← Atgal</a>
  </div>

  <?php if ($klaida): ?><div class="alert alert--err"><?= h($klaida) ?></div><?php endif; ?>

  <form class="formcard" method="post" enctype="multipart/form-data">
    <div class="row">
      <label>Pavadinimas *</label>
      <input type="text" name="pavadinimas" value="<?= h($d['pavadinimas']) ?>" required>
    </div>

    <div class="row">
      <label>Trumpas tekstas (tipas, rodomas ženkliuke)</label>
      <input type="text" name="trumpas" value="<?= h($d['trumpas']) ?>" placeholder="pvz. YouTube vaizdo įrašas">
    </div>

    <div class="row">
      <label>Pilnas tekstas / aprašymas</label>
      <textarea name="pilnas"><?= h($d['pilnas']) ?></textarea>
    </div>

    <div class="grid2">
      <div class="row">
        <label>Formatas</label>
        <select name="formatas">
          <option value="16x9" <?= $d['formatas']==='16x9'?'selected':'' ?>>16:9 (horizontalus)</option>
          <option value="9x16" <?= $d['formatas']==='9x16'?'selected':'' ?>>9:16 (vertikalus)</option>
        </select>
      </div>
      <div class="row">
        <label>Kategorija (filtrui)</label>
        <select name="kategorija">
          <option value="16x9"     <?= $d['kategorija']==='16x9'?'selected':'' ?>>16:9</option>
          <option value="9x16"     <?= $d['kategorija']==='9x16'?'selected':'' ?>>9:16</option>
          <option value="ads"      <?= $d['kategorija']==='ads'?'selected':'' ?>>Reklama</option>
          <option value="showreel" <?= $d['kategorija']==='showreel'?'selected':'' ?>>Showreel</option>
        </select>
      </div>
    </div>

    <div class="grid2">
      <div class="row">
        <label>Trukmė</label>
        <input type="text" name="trukme" value="<?= h($d['trukme']) ?>" placeholder="pvz. 12:40">
      </div>
      <div class="row">
        <label>YouTube nuoroda (neprivaloma – automatinė miniatiūra)</label>
        <input type="text" name="nuoroda" value="<?= h($d['nuoroda']) ?>" placeholder="https://www.youtube.com/watch?v=...">
      </div>
    </div>

    <div class="row">
      <label>Nuotrauka (neprivaloma – jei nori savo, o ne YouTube)</label>
      <input type="file" name="nuotrauka" accept="image/*">
      <?php if ($peek): ?><img class="preview" src="<?= h($peek) ?>" alt="peržiūra"><?php endif; ?>
    </div>

    <div class="formactions">
      <button type="submit" class="btn btn--main"><?= $id ? 'Išsaugoti pakeitimus' : 'Pridėti' ?></button>
      <a class="btn" href="darbai.php">Atšaukti</a>
    </div>
  </form>

<?php require __DIR__ . '/footer.php'; ?>
