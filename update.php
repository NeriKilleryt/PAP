<?php
include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/config.php'; // Certifique-se de que o caminho está correto

$title = 'Atualizar Utilizador';

// Conectar ao banco de dados usando PDO
$conn = connect_db();

// Verificar se o ID do utilizador foi passado
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Preparar e executar a query de seleção
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Buscar as informações do utilizador
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verificar se o formulário foi enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Verificar se os campos 'perfil' e 'status' foram enviados
            if (isset($_POST['perfil'], $_POST['status']) && !empty($_POST['perfil']) && !empty($_POST['status'])) {
                $perfil = intval($_POST['perfil']); // Valor do perfil enviado pelo formulário
                $status = htmlspecialchars($_POST['status']); // Valor do status enviado pelo formulário

                try {
                    // Preparar e executar a query de atualização
                    $sql = "UPDATE users SET Perfil = :perfil, status = :status WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':perfil', $perfil, PDO::PARAM_INT);
                    $stmt->bindParam(':status', $status, PDO::PARAM_STR);
                    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

                    if ($stmt->execute()) {
                        echo "<div class='alert alert-success'>Perfil e status atualizados com sucesso.</div>";
                        // Redirecionar para read.php com o ID do utilizador
                        header("Location: read.php?id=" . $user_id);
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>Erro ao atualizar o perfil e o status.</div>";
                    }
                } catch (PDOException $e) {
                    echo "<div class='alert alert-danger'>Erro ao atualizar: " . $e->getMessage() . "</div>";
                }
            } else {
                echo "<div class='alert alert-warning'>Por favor, selecione um perfil e um status.</div>";
            }
        } else {
            // Exibir o formulário com as informações do utilizador preenchidas
            ?>
            <form action="update.php?id=<?php echo htmlspecialchars($user_id); ?>" method="post" class="p-4 border rounded">
                <div class="mb-3">
                    <label for="nome" class="form-label">Nome:</label>
                    <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($user['Nome']); ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['Email']); ?>" readonly>
                </div>

                <div class="mb-3">
                    <label for="perfil" class="form-label">Perfil:</label>
                    <select id="perfil" name="perfil" class="form-select" required>
                        <option value="1" <?php if ($user['Perfil'] == 1) echo 'selected'; ?>>Administrador</option>
                        <option value="2" <?php if ($user['Perfil'] == 2) echo 'selected'; ?>>Utilizador</option>
                        <option value="3" <?php if ($user['Perfil'] == 3) echo 'selected'; ?>>Colaborador</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label">Status:</label>
                    <select id="status" name="status" class="form-select" required>
                        <option value="Ativo" <?php if ($user['status'] == 'Ativo') echo 'selected'; ?>>Ativo</option>
                        <option value="Banido" <?php if ($user['status'] == 'Banido') echo 'selected'; ?>>Banido</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Atualizar</button>
            </form>
            <?php
        }
    } else {
        echo "<div class='alert alert-danger'>Utilizador não encontrado.</div>";
    }
} else {
    echo "<div class='alert alert-danger'>ID do utilizador inválido ou não fornecido.</div>";
}
?>

<?php
// Incluir o rodapé
require(__DIR__ . '/inc/footer.php');
?>