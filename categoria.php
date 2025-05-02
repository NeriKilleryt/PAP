<?php
require(__DIR__ . '/inc/header.php');
$title = 'Categoria';
// Captura o ID da URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verifica se o ID é válido
if ($id > 0) {
    try {
        // Conexão com o banco de dados usando PDO
        include 'inc/config.php';
        $conn = connect_db();
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Consulta para buscar a categoria pelo ID
        $sql = "SELECT nome FROM categoria WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        die("Erro ao buscar categoria: " . $e->getMessage());
    }

    // Bloco centralizado
    if ($categoria) {
        echo "<h1>". htmlspecialchars($categoria['nome']) . "</h1>";

        // Consulta para buscar ferramentas relacionadas à categoria
        try {
            $sqlFerramentas = "SELECT f.*, m.nome AS nomeMarca FROM ferramentas f LEFT JOIN marca m ON f.idMarca = m.id WHERE f.idCategoria = :id";
            $stmtFerramentas = $conn->prepare($sqlFerramentas);
            $stmtFerramentas->bindParam(':id', $id, PDO::PARAM_INT);
            $stmtFerramentas->execute();

            $ferramentas = $stmtFerramentas->fetchAll(PDO::FETCH_ASSOC);

            if ($ferramentas) {
                echo "<div class='container mt-5'>";
                echo "<div class='row'>";
                foreach ($ferramentas as $ferramenta) {
                    echo "<div class='col-md-4 mb-4'>";
                    echo "<div class='card h-100'>";

                    // Imagem da ferramenta
                    if (!empty($ferramenta['imagem'])) {
                        echo "<img src='" . htmlspecialchars($ferramenta['imagem']) . "' class='card-img-top' alt='Imagem da ferramenta'>";
                    } else {
                        echo "<img src='public/images/default-tool.jpg' class='card-img-top' alt='Imagem padrão'>";
                    }

                    // Detalhes da ferramenta
                    echo "<div class='card-body'>";
                    echo "<h5 class='card-title'>" . htmlspecialchars($ferramenta['nome']) . "</h5>";
                    echo "<p class='card-text'><strong>Descrição:</strong> " . htmlspecialchars($ferramenta['descricao']) . "</p>";
                    echo "<p class='card-text'><strong>Marca:</strong> " . htmlspecialchars($ferramenta['nomeMarca'] ?? 'Marca desconhecida') . "</p>";
                    echo "</div>";

                    // Links das lojas
                    echo "<div class='card-footer'>";
                    echo "<h6>Informações das Lojas</h6>";
                    echo "<ul class='list-unstyled'>";
                    if (!empty($ferramenta['loja1_nome'])) {
                        echo "<li><a href='" . htmlspecialchars($ferramenta['loja1_link']) . "' target='_blank'>" . htmlspecialchars($ferramenta['loja1_nome']) . "</a></li>";
                    }
                    if (!empty($ferramenta['loja2_nome'])) {
                        echo "<li><a href='" . htmlspecialchars($ferramenta['loja2_link']) . "' target='_blank'>" . htmlspecialchars($ferramenta['loja2_nome']) . "</a></li>";
                    }
                    if (!empty($ferramenta['loja3_nome'])) {
                        echo "<li><a href='" . htmlspecialchars($ferramenta['loja3_link']) . "' target='_blank'>" . htmlspecialchars($ferramenta['loja3_nome']) . "</a></li>";
                    }
                    echo "</ul>";
                    echo "</div>";

                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
                echo "</div>";
            } else {
                echo "<p>Nenhuma ferramenta encontrada para esta categoria.</p>";
            }
        } catch (PDOException $e) {
            echo "<p>Erro ao buscar ferramentas: " . htmlspecialchars($e->getMessage()) . "</p>";
        }
    } else {
        echo "<h1>Categoria não encontrada</h1>";
    }
} else {
    echo "<h1>ID inválido ou não fornecido</h1>";
}
?>
<?php
// Incluir o rodapé
require __DIR__ . '/inc/footer.php';
?>