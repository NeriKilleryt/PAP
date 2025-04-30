<?php
// Incluir o cabeçalho
require(__DIR__ . '/inc/header.php');

$title = 'Contato';
// Conectar ao banco de dados
include 'inc/config.php'; // Certifique-se de que o caminho está correto
$conn = connect_db();

// Buscar as ferramentas no banco de dados
try {
    $sql = "SELECT * FROM loja";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $loja = $stmt->fetchAll(PDO::FETCH_ASSOC); // Alterado para $loja
} catch (PDOException $e) {
    die("Erro ao buscar loja: " . $e->getMessage());
}
?>
<div class="container mt-4">
    <h1 class="mb-4 text-center">Contacto</h1>
    <?php if (!empty($loja)): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Nome</th>
                    <th>Contacto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($loja as $lojas): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($lojas['Nome']); ?></td>
                        <td><?php echo htmlspecialchars($lojas['Contacto']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">Nenhuma contacto encontrada no momento.</p>
    <?php endif; ?>
</div>

<?php
// Incluir o rodapé
require __DIR__ . '/inc/footer.php';
?>