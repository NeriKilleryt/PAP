<?php
session_start();
include __DIR__ . '/inc/config.php';
include __DIR__ . '/inc/header.php';

// Verifica se o usuário é administrador ou colaborador
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !in_array($_SESSION['perfil'], [1, 3])) {
    die("Acesso negado.");
}

$title = 'Adicionar Ferramenta';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário
    $nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
    $descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
    $idCategoria = isset($_POST['idCategoria']) ? intval($_POST['idCategoria']) : null;
    $idMarca = isset($_POST['idMarca']) ? intval($_POST['idMarca']) : null;
    $imagem = null;

    // Captura os dados das lojas
    $loja1_nome = isset($_POST['loja1_nome']) ? trim($_POST['loja1_nome']) : null;
    $loja1_link = isset($_POST['loja1_link']) ? trim($_POST['loja1_link']) : null;
    $loja2_nome = isset($_POST['loja2_nome']) ? trim($_POST['loja2_nome']) : null;
    $loja2_link = isset($_POST['loja2_link']) ? trim($_POST['loja2_link']) : null;
    $loja3_nome = isset($_POST['loja3_nome']) ? trim($_POST['loja3_nome']) : null;
    $loja3_link = isset($_POST['loja3_link']) ? trim($_POST['loja3_link']) : null;

    // Upload da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $imagem = 'uploads/' . basename($_FILES['imagem']['name']);
        move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem);
    }

    // Conecta ao banco de dados
    $conn = connect_db();

    try {
        // Insere a nova ferramenta na tabela `ferramentas`
        $sql = "INSERT INTO `ferramentas` (nome, descricao, idCategoria, idMarca, imagem, loja1_nome, loja1_link, loja2_nome, loja2_link, loja3_nome, loja3_link) 
                VALUES (:nome, :descricao, :idCategoria, :idMarca, :imagem, :loja1_nome, :loja1_link, :loja2_nome, :loja2_link, :loja3_nome, :loja3_link)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':descricao' => $descricao,
            ':idCategoria' => $idCategoria,
            ':idMarca' => $idMarca,
            ':imagem' => $imagem,
            ':loja1_nome' => $loja1_nome,
            ':loja1_link' => $loja1_link,
            ':loja2_nome' => $loja2_nome,
            ':loja2_link' => $loja2_link,
            ':loja3_nome' => $loja3_nome,
            ':loja3_link' => $loja3_link
        ]);

        // Redireciona para a página inicial após a adição bem-sucedida
        header("Location: home.php");
        exit();
    } catch (PDOException $e) {
        $error_message = "Erro ao adicionar a ferramenta: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Adicionar Ferramenta</h1>

        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger text-center">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <form action="add_tool.php" method="post" enctype="multipart/form-data" class="p-4 border rounded bg-light">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição:</label>
                <textarea id="descricao" name="descricao" class="form-control" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="idCategoria" class="form-label">Categoria:</label>
                <input type="number" id="idCategoria" name="idCategoria" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="idMarca" class="form-label">Marca:</label>
                <input type="number" id="idMarca" name="idMarca" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem:</label>
                <input type="file" id="imagem" name="imagem" class="form-control">
            </div>

            <h5 class="mt-4">Informações das Lojas</h5>
            <div class="mb-3">
                <label for="loja1_nome" class="form-label">Loja 1 Nome:</label>
                <input type="text" id="loja1_nome" name="loja1_nome" class="form-control">
            </div>
            <div class="mb-3">
                <label for="loja1_link" class="form-label">Loja 1 Link:</label>
                <input type="url" id="loja1_link" name="loja1_link" class="form-control">
            </div>
            <div class="mb-3">
                <label for="loja2_nome" class="form-label">Loja 2 Nome:</label>
                <input type="text" id="loja2_nome" name="loja2_nome" class="form-control">
            </div>
            <div class="mb-3">
                <label for="loja2_link" class="form-label">Loja 2 Link:</label>
                <input type="url" id="loja2_link" name="loja2_link" class="form-control">
            </div>
            <div class="mb-3">
                <label for="loja3_nome" class="form-label">Loja 3 Nome:</label>
                <input type="text" id="loja3_nome" name="loja3_nome" class="form-control">
            </div>
            <div class="mb-3">
                <label for="loja3_link" class="form-label">Loja 3 Link:</label>
                <input type="url" id="loja3_link" name="loja3_link" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary w-100">Adicionar Ferramenta</button>
            <a href="index.php" class="btn btn-secondary">Voltar</a>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Incluir o rodapé
include __DIR__ . '/inc/footer.php';
?>