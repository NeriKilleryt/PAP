<?php
// Captura o ID da URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verifica se o ID é válido
if ($id > 0) {
    echo "<h1>Detalhes da Ferramenta</h1>";
    echo "<p>ID da Ferramenta: $id</p>";
    // Exemplo de lógica para buscar detalhes da ferramenta
    // Substitua pelo código real para buscar informações do banco de dados
    echo "<p>Nome: Ferramenta Exemplo</p>";
    echo "<p>Descrição: Esta é uma descrição de exemplo para a ferramenta com ID $id.</p>";
} else {
    echo "<h1>ID inválido ou não fornecido</h1>";
}
?>
