<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../includes/functions.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $id = (int)$_POST['id'];
    $d = get_darbas($id);
    if ($d) {
        trinti_nuotrauka($d['nuotrauka']);          // ištrinam failą
        $st = db()->prepare("DELETE FROM darbai WHERE id = ?");
        $st->execute([$id]);
    }
}
header('Location: darbai.php?ok=istrintas');
exit;
