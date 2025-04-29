<?php
function check_auth() {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        header("Location: login.php");
        exit();
    }
}

function check_admin() {
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['perfil'] !== '1') {
        header("Location: login.php");
        exit();
    }
}
?>