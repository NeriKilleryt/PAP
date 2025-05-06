<?php
// Inicia a sessão, caso ainda não tenha sido iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Define o título da página
$title = 'Mensagem';

// Verifica se o utilizador está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

require(__DIR__ . '/inc/header.php');

// Conecta ao banco de dados
include 'inc/config.php';
$conn = connect_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = htmlspecialchars($_POST['nome']); // Nome do remetente
    $email = htmlspecialchars($_POST['email']); // Email do remetente
    $mensagem = htmlspecialchars($_POST['mensagem']); // Conteúdo da mensagem

    if (!empty($nome) && !empty($email) && !empty($mensagem)) {
        // Insere a mensagem no banco de dados
        $stmt = $conn->prepare("INSERT INTO mensagens (nome, email, mensagem, data_envio) VALUES (?, ?, ?, NOW())");
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $mensagem);

        if ($stmt->execute()) {
            $success_message = "Mensagem enviada com sucesso!";
        } else {
            $error_message = "Erro ao enviar a mensagem.";
        }
    } else {
        $error_message = "Todos os campos são obrigatórios.";
    }
}
?>

<div class="container mt-4">
    <h1 class="mb-4 text-center">Enviar Mensagem</h1>
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
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="mensagem" class="form-label">Mensagem</label>
            <textarea class="form-control" id="mensagem" name="mensagem" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>