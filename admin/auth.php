<?php

require_once __DIR__ . '/../config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


function is_logged_in() {
    return !empty($_SESSION['admin_id']);
}


function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
}
