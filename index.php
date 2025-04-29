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

try {
    $sql = "SELECT * FROM categoria";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $ferramentas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar categoria: " . $e->getMessage());
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Bem-vindo à WiKi Ferramentas</h1>

    <div class="row">
        <!-- Coluna principal -->
        <div class="col-md-12">
            <p class="lead text-center">
                Explore as melhores ferramentas disponíveis no mercado. Pesquise, veja detalhes e encontre as melhores opções para suas necessidades.
            </p>
            <p class="text-center">
                Utilize a barra de navegação acima para explorar o site.
            </p>
        </div>
    </div>
</div>

<div class="container mt-4">
    <h1 class="mb-4 text-center">Categorias</h1>
    <div class="row g-4">
        <?php if (!empty($ferramentas)): ?>
            <?php foreach ($ferramentas as $ferramenta): ?>
                <div class="col-md-4">
                    <div class="card h-95">
                        <img src="<?php echo htmlspecialchars($ferramenta['imagem']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($ferramenta['nome']); ?>">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?php echo htmlspecialchars($ferramenta['nome']); ?></h5>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>                      
            <p class="text-center">Nenhuma categoria encontrada no momento.</p>
        <?php endif; ?>
    </div>
</div>                    


<?php
require __DIR__ . '/inc/footer.php';
?>