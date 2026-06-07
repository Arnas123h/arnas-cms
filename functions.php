<?php
require_once __DIR__ . '/../config.php';


function h($str) {
    return htmlspecialchars((string)$str, ENT_QUOTES, 'UTF-8');
}


function get_settings() {
    static $cache = null;
    if ($cache === null) {
        $cache = [];
        $rows = db()->query("SELECT raktas, reiksme FROM settings")->fetchAll();
        foreach ($rows as $r) {
            $cache[$r['raktas']] = $r['reiksme'];
        }
    }
    return $cache;
}


function setting($raktas, $default = '') {
    $s = get_settings();
    return isset($s[$raktas]) && $s[$raktas] !== '' ? $s[$raktas] : $default;
}


function get_darbai() {
    return db()->query("SELECT * FROM darbai ORDER BY id DESC")->fetchAll();
}


function get_darbas($id) {
    $st = db()->prepare("SELECT * FROM darbai WHERE id = ?");
    $st->execute([(int)$id]);
    return $st->fetch();
}


function yt_id($url) {
    if (!$url) return null;
    if (preg_match('~youtu\.be/([a-zA-Z0-9_-]+)~', $url, $m)) return $m[1];
    if (preg_match('~[?&]v=([a-zA-Z0-9_-]+)~', $url, $m)) return $m[1];
    if (preg_match('~/(shorts|embed|live)/([a-zA-Z0-9_-]+)~', $url, $m)) return $m[2];
    return null;
}


function yt_thumb($url) {
    $id = yt_id($url);
    return $id ? "https://img.youtube.com/vi/{$id}/hqdefault.jpg" : '';
}


function issaugoti_nuotrauka($field) {
    if (empty($_FILES[$field]) || $_FILES[$field]['error'] === UPLOAD_ERR_NO_FILE) {
        return ['', ''];
    }
    $f = $_FILES[$field];
    if ($f['error'] !== UPLOAD_ERR_OK) return ['', 'Nuotraukos įkėlimo klaida.'];
    if ($f['size'] > 5 * 1024 * 1024) return ['', 'Nuotrauka per didelė (max 5 MB).'];

    $info = @getimagesize($f['tmp_name']);
    if ($info === false) return ['', 'Failas nėra paveikslėlis.'];

    $leistini = ['image/jpeg'=>'jpg', 'image/png'=>'png', 'image/webp'=>'webp', 'image/gif'=>'gif'];
    if (!isset($leistini[$info['mime']])) return ['', 'Leidžiami tik JPG, PNG, WEBP, GIF.'];

    $dir = __DIR__ . '/../nuotraukos';
    if (!is_dir($dir)) mkdir($dir, 0775, true);

    $vardas = time() . '_' . bin2hex(random_bytes(4)) . '.' . $leistini[$info['mime']];
    if (!move_uploaded_file($f['tmp_name'], $dir . '/' . $vardas)) {
        return ['', 'Nepavyko išsaugoti failo serveryje.'];
    }
    return ['nuotraukos/' . $vardas, ''];
}


function trinti_nuotrauka($kelias) {
    if ($kelias && strpos($kelias, 'nuotraukos/') === 0) {
        $pilnas = __DIR__ . '/../' . $kelias;
        if (is_file($pilnas)) @unlink($pilnas);
    }
}
