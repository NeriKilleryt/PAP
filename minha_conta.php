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
    $sql = "SELECT * FROM users";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $ferramentas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro ao buscar users: " . $e->getMessage());
}


// Verificar se o ID do utilizador foi passado
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Verificar se o formulário foi enviado
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        // Capturar os dados do formulário
        $nome = htmlspecialchars($_POST['nome']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $data_nascimento = htmlspecialchars($_POST['data_nascimento']);
        $contacto = htmlspecialchars($_POST['contacto']);
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Minha Conta</h1>

    <div class="row">
        <!-- Coluna principal -->
        <div class="col-md-12">
            <p class="lead text-center">
                Aqui você pode visualizar e editar suas informações pessoais.
            </p>
        </div>
    </div>
</div>

<div class="container mt-4">
    <h1 class="mb-4 text-center">Detalhes da Conta</h1>
    <div class="row g-4">
        <?php if (!empty($users)): ?>
            <?php foreach ($users as $user): ?>

            <div class="col-md-12">
                <div class="card h-95">
                    <img src="<?php echo htmlspecialchars($user['imagem']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($user['nome']); ?>">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?php echo htmlspecialchars($user['nome']); ?></h5>
                        <p class="card-text">Email: <?php echo htmlspecialchars($user['email']); ?></p>
                        <p class="card-text">Data de Nascimento: <?php echo htmlspecialchars($user['data_nascimento']); ?></p>
                        <p class="card-text">Contacto: <?php echo htmlspecialchars($user['contacto']); ?></p>
                    </div>    
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Nenhum utilizador encontrado no momento.</p>
        <?php endif; ?>
    </div>
</div>
