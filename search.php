<?php
require(__DIR__ . '/inc/header.php');

$title = 'Pesquisar';

// Captura a consulta de pesquisa
$query = isset($_GET['query']) ? trim($_GET['query']) : '';

echo '<div class="container mt-4">';
echo '<h1 class="mb-4 text-center">Resultados da Pesquisa</h1>';

if ($query) {
    // Conecta ao banco de dados
    require __DIR__ . '/inc/config.php';
    $conn = connect_db();

    try {
        // Prepara a query para buscar resultados no nome ou na descrição
        $sql = "SELECT * FROM ferramentas WHERE nome LIKE :query OR descricao LIKE :query";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':query' => '%' . $query . '%']);

        // Verifica se há resultados
        if ($stmt->rowCount() > 0) {
            echo "<h2 class='mb-4'>Resultados da pesquisa para: <strong>" . htmlspecialchars($query) . "</strong></h2>";
            echo "<div class='row'>";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Exibe cada resultado como um cartão
                echo "<div class='col-md-4 mb-4'>";
                echo "<div class='card h-100'>";
                if (!empty($row['imagem'])) {
                    echo "<img src='" . htmlspecialchars($row['imagem']) . "' class='card-img-top' alt='Imagem da ferramenta'>";
                } else {
                    echo "<img src='public/images/default-tool.jpg' class='card-img-top' alt='Imagem padrão'>";
                }
                echo "<div class='card-body'>";
                echo "<h5 class='card-title'>" . htmlspecialchars($row['nome']) . "</h5>";
                echo "<p class='card-text'>" . htmlspecialchars($row['descricao']) . "</p>";
                echo "</div>";
                echo "<div class='card-footer text-center'>";
                echo "<a href='detalhes.php?id=" . htmlspecialchars($row['id']) . "&query=" . urlencode($query) . "' class='btn btn-primary'>Ver Detalhes</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p class='alert alert-warning'>Nenhum resultado encontrado para: <strong>" . htmlspecialchars($query) . "</strong></p>";
        }
    } catch (PDOException $e) {
        echo "<p class='alert alert-danger'>Erro: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='alert alert-info'>Por favor, insira um termo de pesquisa.</p>";
}

echo '</div>';

require(__DIR__ . '/inc/footer.php');
?>