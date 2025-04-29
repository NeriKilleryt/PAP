<?php
// Iniciar sessão
if (!isset($_SESSION)) {
    session_start();
}

// Verificar se o utilizador está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Verificar se o utilizador é administrador ou é colobarador
if (!isset($_SESSION['perfil']) || ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3)) {
    header('Location: home.php');
    exit;
}

$title = 'Promoções';
// Incluir o cabeçalho
require(__DIR__ . '/inc/header.php');

// Incluir o arquivo de configuração
include 'inc/config.php';

// Inicializar a conexão com o banco de dados
$conn = connect_db();

// Incluir o PHPMailer manualmente
require __DIR__ . '/PHPMailer/src/PHPMailer.php';
require __DIR__ . '/PHPMailer/src/SMTP.php';
require __DIR__ . '/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Função para enviar emails
function enviarEmailsPromocionais($assunto, $mensagem, $conn) {
    try {
        // Buscar emails dos utilizadores registados
        $sql = "SELECT Email FROM users";
        $stmt = $conn->query($sql);
        $emails = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (empty($emails)) {
            return "Nenhum email encontrado para enviar promoções.";
        }

        // Configurar o PHPMailer
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'nerigoncalo96@gmail.com'; // Seu endereço de email
        $mail->Password = 'Gneri06!'; // Use a senha de aplicativo gerada pelo Google
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Configurações do remetente
        $mail->setFrom('nerigoncalo96@gmail.com', 'WiKi Ferramentas');

        // Adicionar destinatários
        foreach ($emails as $email) {
            $mail->addAddress($email);
        }

        // Conteúdo do email
        $mail->isHTML(true);
        $mail->Subject = $assunto;
        $mail->Body = $mensagem;

        // Enviar email
        $mail->send();
        return "Emails enviados com sucesso para todos os utilizadores registados!";
    } catch (Exception $e) {
        return "Erro ao enviar emails: " . $mail->ErrorInfo;
    }
}

// Variáveis para mensagens de feedback
$success_message = '';
$error_message = '';

// Processar o formulário de envio de promoções
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assunto = isset($_POST['assunto']) ? trim($_POST['assunto']) : '';
    $mensagem = isset($_POST['mensagem']) ? trim($_POST['mensagem']) : '';

    if (!empty($assunto) && !empty($mensagem)) {
        $feedback = enviarEmailsPromocionais($assunto, $mensagem, $conn);
        if (strpos($feedback, 'sucesso') !== false) {
            $success_message = $feedback;
        } else {
            $error_message = $feedback;
        }
    } else {
        $error_message = "Por favor, preencha todos os campos.";
    }
}
?>

<div class="container mt-5">
    <h1 class="text-center mb-4">Enviar Promoções</h1>

    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success text-center"><?php echo htmlspecialchars($success_message); ?></div>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger text-center"><?php echo htmlspecialchars($error_message); ?></div>
    <?php endif; ?>

    <form action="promocoes.php" method="post">
        <div class="mb-3">
            <label for="assunto" class="form-label">Assunto:</label>
            <input type="text" id="assunto" name="assunto" class="form-control" placeholder="Digite o assunto do email" required>
        </div>
        <div class="mb-3">
            <label for="mensagem" class="form-label">Mensagem:</label>
            <textarea id="mensagem" name="mensagem" class="form-control" rows="6" placeholder="Digite a mensagem da promoção" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Enviar Promoções</button>
    </form>
</div>

<?php
// Incluir o rodapé
require __DIR__ . '/inc/footer.php';
?>