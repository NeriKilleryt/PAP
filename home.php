<?php
require(__DIR__ . '/inc/header.php');

$title = 'Home';

// Conectar ao banco de dados
include 'inc/config.php'; // Certifique-se de que o caminho está correto
$conn = connect_db();

// Buscar as ferramentas no banco de dados
try {
    $sql = "SELECT * FROM ferramentas";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $ferramentas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar ferramentas: " . $e->getMessage());
}
?>

<div class="container mt-4">
    <h1 class="mb-4 text-center">Ferramentas</h1>
    <div class="row g-4">
        <?php if (!empty($ferramentas)): ?>
            <?php foreach ($ferramentas as $ferramenta): ?>
                <div class="col-md-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($ferramenta['imagem']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($ferramenta['nome']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($ferramenta['nome']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($ferramenta['descricao']); ?></p>
                        </div>
                        <div class="dropdown m-3">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Lojas
                            </button>
                            <ul class="dropdown-menu">
                                <?php if (!empty($ferramenta['loja1_nome']) && !empty($ferramenta['loja1_link'])): ?>
                                    <li><a class="dropdown-item" href="<?php echo htmlspecialchars($ferramenta['loja1_link']); ?>" target="_blank"><?php echo htmlspecialchars($ferramenta['loja1_nome']); ?></a></li>
                                <?php endif; ?>
                                <?php if (!empty($ferramenta['loja2_nome']) && !empty($ferramenta['loja2_link'])): ?>
                                    <li><a class="dropdown-item" href="<?php echo htmlspecialchars($ferramenta['loja2_link']); ?>" target="_blank"><?php echo htmlspecialchars($ferramenta['loja2_nome']); ?></a></li>
                                <?php endif; ?>
                                <?php if (!empty($ferramenta['loja3_nome']) && !empty($ferramenta['loja3_link'])): ?>
                                    <li><a class="dropdown-item" href="<?php echo htmlspecialchars($ferramenta['loja3_link']); ?>" target="_blank"><?php echo htmlspecialchars($ferramenta['loja3_nome']); ?></a></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Nenhuma ferramenta encontrada no momento.</p>
        <?php endif; ?>
    </div>
</div>

<?php
require __DIR__ . '/inc/footer.php';
?>