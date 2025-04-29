<?php
require(__DIR__ . '/inc/header.php');

// Verifica se o ID foi passado na URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container mt-5'><p class='alert alert-danger'>ID inválido ou não fornecido.</p></div>";
    require(__DIR__ . '/inc/footer.php');
    exit;
}

$id = intval($_GET['id']);

// Conecta ao banco de dados
require __DIR__ . '/inc/config.php';
$conn = connect_db();

try {
    // Busca os detalhes da ferramenta pelo ID
    $sql = "SELECT * FROM ferramentas WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':id' => $id]);

    // Verifica se a ferramenta foi encontrada
    if ($stmt->rowCount() === 0) {
        echo "<div class='container mt-5'><p class='alert alert-warning'>Ferramenta não encontrada.</p></div>";
        require(__DIR__ . '/inc/footer.php');
        exit;
    }

    $ferramenta = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div class='container mt-5'><p class='alert alert-danger'>Erro ao buscar os detalhes: " . $e->getMessage() . "</p></div>";
    require(__DIR__ . '/inc/footer.php');
    exit;
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4"><?php echo htmlspecialchars($ferramenta['nome']); ?></h1>

    <div class="row">
        <!-- Imagem da ferramenta -->
        <div class="col-md-6">
            <?php if (!empty($ferramenta['imagem'])): ?>
                <img src="<?php echo htmlspecialchars($ferramenta['imagem']); ?>" class="img-fluid rounded" alt="Imagem da ferramenta">
            <?php else: ?>
                <img src="public/images/default-tool.jpg" class="img-fluid rounded" alt="Imagem padrão">
            <?php endif; ?>
        </div>

        <!-- Detalhes da ferramenta -->
        <div class="col-md-6">
            <h3>Descrição</h3>
            <p><?php echo htmlspecialchars($ferramenta['descricao']); ?></p>
            <h3>Marca</h3>
            <p><?php echo htmlspecialchars($ferramenta['idMarca']); ?></p>

            <h3>Informações das Lojas</h3>
            <ul>
                <?php if (!empty($ferramenta['loja1_nome'])): ?>
                    <li><strong><?php echo htmlspecialchars($ferramenta['loja1_nome']); ?>:</strong> <a href="<?php echo htmlspecialchars($ferramenta['loja1_link']); ?>" target="_blank">Visitar Loja</a></li>
                <?php endif; ?>
                <?php if (!empty($ferramenta['loja2_nome'])): ?>
                    <li><strong><?php echo htmlspecialchars($ferramenta['loja2_nome']); ?>:</strong> <a href="<?php echo htmlspecialchars($ferramenta['loja2_link']); ?>" target="_blank">Visitar Loja</a></li>
                <?php endif; ?>
                <?php if (!empty($ferramenta['loja3_nome'])): ?>
                    <li><strong><?php echo htmlspecialchars($ferramenta['loja3_nome']); ?>:</strong> <a href="<?php echo htmlspecialchars($ferramenta['loja3_link']); ?>" target="_blank">Visitar Loja</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Botão para voltar -->
    <div class="text-center mt-4">
        <a href="search.php" class="btn btn-secondary">Voltar</a>
    </div>
</div>

<?php
require(__DIR__ . '/inc/footer.php');
?>