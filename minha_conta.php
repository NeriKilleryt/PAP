<?php
// Inicia a sessão, caso ainda não tenha sido iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Define o título da página
$title = 'Index';
require(__DIR__ . '/inc/header.php');

// Conecta ao banco de dados
require __DIR__ . '/inc/config.php'; // Caminho absoluto para o arquivo config.php
$conn = connect_db();

try {
    // Prepara a query para buscar todos os usuários
    $sql = "SELECT nome, email, data_nascimento, imagem FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Verifica se há resultados
    if ($stmt->rowCount() > 0) {
        echo "<h2>Lista de Utilizadores</h2>";
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Nome</th><th>Email</th><th>Data de registo</th><th>imagem</th></tr></thead>";
        echo "<tbody>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['data_nascimento']) . "</td>";
            echo "<td>" . htmlspecialchars($row['imagem']) . "</td>";
            echo "</tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>Nenhum utilizador encontrado.</p>";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
