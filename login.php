<?php
session_start();
$title = 'Login';
require(__DIR__ . '/inc/header.php');

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Inclui o arquivo de configuração para conexão com o banco de dados
    require __DIR__ . '/inc/config.php';
    $conn = connect_db();

    try {
        // Prepara a consulta para verificar o email
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        // Verifica se o usuário existe
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica se a senha está correta
            if (password_verify($password, $user['password'])) {
                // Configura as variáveis de sessão
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $user['email'];
                $_SESSION['nome'] = $user['Nome'];
                $_SESSION['perfil'] = $user['Perfil']; // Supondo que você tenha um campo 'Perfil' na tabela
                $_SESSION['contacto'] = $user['Contacto'];

                // Redireciona com base no perfil
                if ($user['Perfil'] == 1) { // Perfil 1 é administrador
                    header("Location: paineladmin.php");
                } else { // Outros perfis
                    header("Location: index.php");
                }
                exit();
            } else {
                // Senha incorreta
                $error_message = "Email ou senha incorretos.";
            }
        } else {
            // Usuário não encontrado
            $error_message = "Os dados inseridos não existem na base de dados.";
        }
    } catch (PDOException $e) {
        // Erro na execução da consulta
        $error_message = "Erro ao acessar o banco de dados: " . $e->getMessage();
    } finally {
        // Fecha a conexão
        unset($stmt);
        unset($conn);
    }
}
?>

<section class="container mt-5">
    <main class="row">
        <div class="col-4"></div>
        <!-- Apresentação do formulário -->
        <section class="col-3 border rounded bg-primary-subtle text-primary-emphasis">
            <p class="h2 d-flex justify-content-center">Login</p>
            <?php if (!empty($error_message)): ?>
                <div class="alert alert-danger text-center">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <div class="mb-4">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email válido" required>
                </div>
                <div class="mb-4">
                    <label for="password">Senha:</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="d-grid gap-2 mb-3">
                    <button type="submit" class="btn btn-primary cursor-pointer" name="submitBtn">Login</button>
                </div>
            </form>
        </section>
    </main>
</section>

<?php
require(__DIR__ . '/inc/footer.php');
?>