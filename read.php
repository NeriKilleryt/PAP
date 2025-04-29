<?php
// Incluir o cabeçalho
include(__DIR__ . '/inc/header.php');

$title = 'Detalhes do Utilizador';

// Incluir o arquivo de configuração
include __DIR__ . '/inc/config.php'; // Certifique-se de que o caminho está correto

// Conectar ao banco de dados usando PDO
$conn = connect_db();

// Inicializar variáveis
$user = null;
$error_message = null;
$success_message = null;

// Verificar se o ID do utilizador foi passado
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Capturar os dados do formulário
        $nome = htmlspecialchars($_POST['nome']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $data_nascimento = htmlspecialchars($_POST['data_nascimento']);
        $contacto = htmlspecialchars($_POST['contacto']);
        $perfil = intval($_POST['perfil']);
        $status = htmlspecialchars($_POST['status']);

        // Atualizar a imagem, se fornecida
        $imagem = null;
        $upload_dir = __DIR__ . '/uploads/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $imagem = 'uploads/' . basename($_FILES['imagem']['name']);
            if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $imagem)) {
                $error_message = "Erro ao mover o arquivo para o diretório de uploads.";
            }
        }

        try {
            // Preparar a query de atualização
            $sql = "UPDATE users 
                    SET Nome = :nome, Email = :email, password = :password, Data_nascimento = :data_nascimento, 
                        Contacto = :contacto, Perfil = :perfil, status = :status, imagem = COALESCE(:imagem, imagem)
                    WHERE id = :id";

            // Se o campo de senha estiver vazio, não atualize a senha
            if (empty($password)) {
                $sql = str_replace(", password = :password", "", $sql);
            }

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);

            if (!empty($password)) {
                $password = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            }

            $stmt->bindParam(':data_nascimento', $data_nascimento, PDO::PARAM_STR);
            $stmt->bindParam(':contacto', $contacto, PDO::PARAM_STR);
            $stmt->bindParam(':perfil', $perfil, PDO::PARAM_INT);
            $stmt->bindParam(':status', $status, PDO::PARAM_STR);
            $stmt->bindParam(':imagem', $imagem, PDO::PARAM_STR);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

            // Executar a query
            if ($stmt->execute()) {
                $success_message = "Dados atualizados com sucesso.";
            } else {
                $error_message = "Erro ao atualizar os dados.";
            }
        } catch (PDOException $e) {
            $error_message = "Erro ao atualizar os dados: " . $e->getMessage();
        }
    }

    // Buscar os dados atualizados do utilizador
    try {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            $error_message = "Utilizador não encontrado.";
        }
    } catch (PDOException $e) {
        $error_message = "Erro ao buscar informações do utilizador: " . $e->getMessage();
    }
} else {
    $error_message = "ID do utilizador inválido ou não fornecido.";
}
?>

<div class="container mt-4">
    <h1 class="mb-4 text-center">Detalhes do Utilizador</h1>

    <?php if ($error_message): ?>
        <div class="alert alert-danger text-center">
            <?php echo htmlspecialchars($error_message); ?>
        </div>
    <?php elseif ($success_message): ?>
        <div class="alert alert-success text-center">
            <?php echo htmlspecialchars($success_message); ?>
        </div>
    <?php elseif ($user): ?>
        <form action="read.php?id=<?php echo htmlspecialchars($user_id); ?>" method="post" enctype="multipart/form-data" class="p-4 border rounded">

            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" id="nome" name="nome" class="form-control" value="<?php echo htmlspecialchars($user['Nome']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['Email']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="text" id="password" name="password" class="form-control" value="<?php echo htmlspecialchars($user['password']); ?>" required>
            </div>

            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" value="<?php echo htmlspecialchars($user['Data_nascimento']); ?>">
            </div>

            <div class="mb-3">
                <label for="contacto" class="form-label">Contacto:</label>
                <input type="text" id="contacto" name="contacto" class="form-control" value="<?php echo htmlspecialchars($user['Contacto']); ?>">
            </div>

            <div class="mb-3">
                <label for="perfil" class="form-label">Tipo de Utilizador:</label>
                <select id="perfil" name="perfil" class="form-select">
                    <option value="1" <?php echo $user['Perfil'] == 1 ? 'selected' : ''; ?>>Admin</option>
                    <option value="2" <?php echo $user['Perfil'] == 2 ? 'selected' : ''; ?>>Utilizador</option>
                    <option value="3" <?php echo $user['Perfil'] == 3 ? 'selected' : ''; ?>>Colaborador</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status:</label>
                <input type="text" id="status" name="status" class="form-control" value="<?php echo htmlspecialchars($user['status']); ?>">
            </div>

            <div class="mb-3">
                <label for="imagem" class="form-label">Imagem:</label>
                <?php if (!empty($user['imagem'])): ?>
                    <img src="<?php echo htmlspecialchars($user['imagem']); ?>" alt="Imagem do utilizador" class="img-thumbnail mb-2" style="max-width: 150px;">
                <?php else: ?>
                    <p>Sem imagem disponível</p>
                <?php endif; ?>
                <input type="file" id="imagem" name="imagem" class="form-control">
            </div>

            <div class="mb-3">
                <label for="data_registo" class="form-label">Data de Registo:</label>
                <input type="text" id="data_registo" name="data_registo" class="form-control" value="<?php echo htmlspecialchars($user['Data_registo']); ?>" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    <?php endif; ?>
</div>

<?php
// Incluir o rodapé
include __DIR__ . '/inc/footer.php';
?>