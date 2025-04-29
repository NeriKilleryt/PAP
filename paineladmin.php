<?php
if (!isset($_SESSION)) {
    session_start();
}

// Verificar se o utilizador está logado
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Verificar se o utilizador é administrador (Perfil = 1 ou 3)
if ($_SESSION['perfil'] != 1 && $_SESSION['perfil'] != 3) {
    header('Location: home.php'); // Redireciona para a página inicial se não for administrador
    exit;
}

$title = 'Dashboard';
// Incluir o cabeçalho
require(__DIR__ . '/inc/header.php');

// Incluir o arquivo de configuração
include 'inc/config.php';

// Conectar ao banco de dados usando PDO
$link = connect_db();

echo "<h1 class='container mt-3'>Dashboard</h1>";

// Função para contar registos
function contaRegistos($link, $tabela) {
    $sql = "SELECT COUNT(*) as Total FROM $tabela";
    if ($result = $link->query($sql)) {
        $row = $result->fetch(PDO::FETCH_ASSOC);
        unset($result);
        return $row['Total'];
    }
}

// Paginação para utilizadores
$users_por_pagina = 5;
$pagina_atual_users = isset($_GET['pagina_users']) ? intval($_GET['pagina_users']) : 1;
$offset_users = ($pagina_atual_users - 1) * $users_por_pagina;

// Paginação para mensagens
$mensagens_por_pagina = 5;
$pagina_atual_mensagens = isset($_GET['pagina_mensagens']) ? intval($_GET['pagina_mensagens']) : 1;
$offset_mensagens = ($pagina_atual_mensagens - 1) * $mensagens_por_pagina;

try {
    // Lista utilizadores com paginação
    $sql_users = "SELECT * FROM users LIMIT :offset, :limit";
    $stmt_users = $link->prepare($sql_users);
    $stmt_users->bindValue(':offset', $offset_users, PDO::PARAM_INT);
    $stmt_users->bindValue(':limit', $users_por_pagina, PDO::PARAM_INT);
    $stmt_users->execute();

    // Lista mensagens com paginação
    $sql_mensagens = "SELECT * FROM mensagens LIMIT :offset, :limit";
    $stmt_mensagens = $link->prepare($sql_mensagens);
    $stmt_mensagens->bindValue(':offset', $offset_mensagens, PDO::PARAM_INT);
    $stmt_mensagens->bindValue(':limit', $mensagens_por_pagina, PDO::PARAM_INT);
    $stmt_mensagens->execute();

    // Total de utilizadores e mensagens
    $total_users = contaRegistos($link, 'users');
    $total_mensagens = contaRegistos($link, 'mensagens');
} catch (PDOException $e) {
    die("ERROR: Não foi possível executar a consulta. " . $e->getMessage());
}
?>

<div class="container mt-4">
    <h2>Utilizadores</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Perfil</th>
                <th>Status</th>
                <th>Data de Registo</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $stmt_users->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['ID']); ?></td>
                    <td><?php echo htmlspecialchars($row['Nome']); ?></td>
                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                    <td><?php echo $row['Perfil'] == 1 ? 'Administrador' : ($row['Perfil'] == 2 ? 'Utilizador' : 'Colaborador'); ?></td>
                    <td><?php echo htmlspecialchars($row['status']); ?></td>
                    <td><?php echo htmlspecialchars($row['Data_registo']); ?></td>
                    <td>
                        <a href="read.php?id=<?php echo htmlspecialchars($row['ID']); ?>" title="Editar Registo"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                        &nbsp;&nbsp;|&nbsp;&nbsp;
                        <a href="delete.php" title="Eliminar Registo"><i class="fa fa-trash" aria-hidden="true"></i></a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <!-- Paginação para utilizadores -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= ceil($total_users / $users_por_pagina); $i++): ?>
                <li class="page-item <?php echo $i == $pagina_atual_users ? 'active' : ''; ?>">
                    <a class="page-link" href="?pagina_users=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>

    <h2>Mensagens</h2>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Mensagem</th>
                <th>Data de Envio</th>
            </tr>
        </thead>
        <tbody id="mensagens-tabela">
            <?php while ($row = $stmt_mensagens->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['nome']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td><?php echo htmlspecialchars($row['mensagem']); ?></td>
                    <td><?php echo htmlspecialchars($row['data_envio']); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <!-- Paginação para mensagens -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= ceil($total_mensagens / $mensagens_por_pagina); $i++): ?>
                <li class="page-item <?php echo $i == $pagina_atual_mensagens ? 'active' : ''; ?>">
                    <a class="page-link" href="?pagina_mensagens=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>

<script>
// Atualiza a tabela de mensagens automaticamente
setInterval(() => {
    fetch('fetch_mensagens.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('mensagens-tabela').innerHTML = data;
        });
}, 5000); // Atualiza a cada 5 segundos
</script>

<?php
// Fecha a ligação ao servidor
unset($link);

// Incluir o rodapé
require __DIR__ . '/inc/footer.php';
?>