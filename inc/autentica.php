<?php
if (! isset($_SESSION)) {
    session_start();
}

// verifica se fez login, isto é, se o utilizador já foi autenticado.
// Esta verificação é obrigatória no início de todas as páginas.
if (!isset($_SESSION['loggedin'])) {
    header("location: index.php");
    exit();
}
?>