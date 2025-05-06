<?php
// Inicia a sessão, caso ainda não tenha sido iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Define o título da página
$title = 'Minha Conta';

// Verifica se o utilizador está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

require(__DIR__ . '/inc/header.php');

// Conecta ao banco de dados
include 'inc/config.php';
$conn = connect_db();

try {
    $user_id = $_SESSION['id']; // Obtém o ID do utilizador logado da sessão

    // Verifica se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nome = htmlspecialchars($_POST['nome']);
        $email = htmlspecialchars($_POST['email']);
        $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
        $data_nascimento = htmlspecialchars($_POST['data_nascimento']);
        $contacto = htmlspecialchars($_POST['contacto']);

        // Atualiza os dados do utilizador no banco de dados
        $sql = "UPDATE users SET Nome = :nome, Email = :email, Data_nascimento = :data_nascimento, Contacto = :contacto";
        if ($password) {
            $sql .= ", Password = :password";
        }
        $sql .= " WHERE id = :id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':data_nascimento', $data_nascimento);
        $stmt->bindParam(':contacto', $contacto);
        if ($password) {
            $stmt->bindParam(':password', $password);
        }
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $success_message = "Dados atualizados com sucesso!";
        } else {
            $error_message = "Erro ao atualizar os dados.";
        }
    }

    // Busca os dados do utilizador
    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Utilizador não encontrado.");
    }
} catch (PDOException $e) {
    die("Erro ao buscar utilizador: " . $e->getMessage());
}
?>

<div class="container mt-4">
    <h1 class="mb-4 text-center">Minha Conta</h1>
    <?php if (isset($success_message)): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>
    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>
    <form method="post" action="">
        <div class="mb-3">
            <label for="nome" class="form-label">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="<?php echo htmlspecialchars($user['Nome']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Nova Senha (opcional)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="mb-3">
            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
            <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($user['Data_nascimento']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="contacto" class="form-label">Contacto</label>
            <input type="text" class="form-control" id="contacto" name="contacto" value="<?php echo htmlspecialchars($user['Contacto']); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
    </form>
</div>
