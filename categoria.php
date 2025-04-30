<?php
// Captura o ID da URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verifica se o ID é válido
if ($id > 0) {
    echo "<h1>Detalhes da Ferramenta</h1>";
    // Substitua pelo código real para buscar informações do banco de dados
    echo "<p>Nome: Ferramenta Exemplo</p>";
} else {
    echo "<h1>ID inválido ou não fornecido</h1>";
}
?>
