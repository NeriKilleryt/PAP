<?php
// Inicia a sessão, caso ainda não tenha sido iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Define o título da página
$title = 'Index';
require(__DIR__ . '/inc/header.php');

// Conecta ao banco de dados
include 'inc/config.php';
$conn = connect_db();
?>
