<?php
require(__DIR__ . '/inc/auth.php');
check_admin();
require(__DIR__ . '/inc/header.php');

$title = ' Ver os Utilizadore';

// Conecta ao banco de dados
require 'config.php';
$conn = connect_db();

try {
    // Prepara a query para buscar todos os usuários
    $sql = "SELECT nome, email, data_registo, perfil FROM user";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Verifica se há resultados
    if ($stmt->rowCount() > 0) {
        echo "<h2>Lista de Utilizadores</h2>";
        echo "<table class='table table-striped'>";
        echo "<thead><tr><th>Nome</th><th>Email</th><th>Data de Registo</th><th>perfil</th></tr></thead>";
        echo "<tbody>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
            echo "<td>" . htmlspecialchars($row['data_registo']) . "</td>";
            echo "<td>" . htmlspecialchars($row['perfil']) . "</td>";
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

require(__DIR__ . '/inc/footer.php');
?>