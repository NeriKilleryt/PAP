<?php
session_start();

// Verifica se o usuário está logado e é administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3)) {
    header("Location: login.php");
    exit;
}

require_once 'inc/config.php'; // Inclui a conexão com a base de dados
include __DIR__ . '/inc/header.php';

// Inicializa a conexão com o banco de dados
$conn = connect_db();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = htmlspecialchars(trim($_POST['nome']));
    $morada = htmlspecialchars(trim($_POST['morada']));
    $contacto = htmlspecialchars(trim($_POST['contacto']));

    if (!empty($nome) && !empty($morada) && !empty($contacto)) {
        // Query para inserir os dados na tabela 'loja'
        $stmt = $conn->prepare("INSERT INTO loja (Nome, Morada, Contacto) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $morada);
        $stmt->bindParam(3, $contacto);

        if ($stmt->execute()) {
            $success_message = "Loja adicionada com sucesso!";
        } else {
            $error_message = "Erro ao adicionar a loja.";
        }

        $stmt = null; // Fecha o statement
    } else {
        $error_message = "Todos os campos são obrigatórios.";
    }
}

$conn = null; // Fecha a conexão
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Loja</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Adicionar Loja</h1>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="morada" class="form-label">Morada</label>
                <input type="text" class="form-control" id="morada" name="morada" required>
            </div>
            <div class="mb-3">
                <label for="contacto" class="form-label">Contacto</label>
                <input type="text" class="form-control" id="contacto" name="contacto" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar</button>
            <a href="index.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
</body>
</html>
<?php
// Incluir o rodapé
include __DIR__ . '/inc/footer.php';
?>