<?php
session_start();

// Verifica se o usuário está logado e é administrador
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3)) {
    header("Location: login.php");
    exit;
}

require_once 'inc/config.php'; // Inclui a conexão com a base de dados

// Inicializa a conexão com o banco de dados
$conn = connect_db();
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = trim($_POST['categoria']);
    $funcao = trim($_POST['funcao']);
    $imagem = $_FILES['imagem'];

    if (!empty($categoria) && !empty($funcao)) {
        $upload_dir = 'uploads/';
        $upload_file = $upload_dir . basename($imagem['name']);
        $image_uploaded = false;

        if (move_uploaded_file($imagem['tmp_name'], $upload_file)) {
            $image_uploaded = true;
        }

        // Update query to include the 'funcao' field
        $stmt = $conn->prepare("INSERT INTO categoria (nome, Funcao, imagem) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $categoria);
        $stmt->bindParam(2, $funcao);
        $stmt->bindParam(3, $upload_file);

        if ($stmt->execute()) {
            $success_message = "Categoria adicionada com sucesso!";
        } else {
            $error_message = "Erro ao adicionar a categoria.";
        }

        $stmt = null; // Fecha o statement
    } else {
        $error_message = "Os campos de categoria e função não podem estar vazios.";
    }
}

$conn = null; // Fecha a conexão
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Categoria</title>
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Adicionar Categoria</h1>
        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success_message); ?></div>
        <?php endif; ?>
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="categoria" class="form-label">Nome da Categoria</label>
                <input type="text" class="form-control" id="categoria" name="categoria" required>
            </div>
            <div class="mb-3">
                <label for="funcao" class="form-label">Função da Categoria</label>
                <input type="text" class="form-control" id="funcao" name="funcao" required>
            </div>
            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem da Categoria</label>
                <input type="file" class="form-control" id="imagem" name="imagem" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Adicionar</button>
            <a href="paineladmin.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>
    <script src="public/js/bootstrap.bundle.min.js"></script>
</body>
</html>
