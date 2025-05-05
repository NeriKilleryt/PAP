<?php
if (!isset($_SESSION)) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) : "WiKi"; ?></title>
    <!-- Carrega a font Open Sans -->
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <!-- Carrega os estilos -->
    <link rel="stylesheet" href="public/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/font-awesome-4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="public/css/style.css"> <!-- Adicione um arquivo CSS personalizado -->
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="public/images/Log.ico" alt="Logo" width="35" height="35">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contato.php">Contactos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sobre.php">Sobre</a>
                    </li>
                </ul>
                <!--Fodge-->

                <!-- Barra de pesquisa -->
                <div class="d-flex justify-content-center w-100">
                    <form class="d-flex" action="search.php" method="get" role="search">
                        <input class="form-control me-2" type="search" name="query" placeholder="Pesquisar" aria-label="Pesquisar" required>
                        <button class="btn btn-outline-success" type="submit">Pesquisar</button>
                    </form>
                </div>

                <div class="d-flex">
                    <?php
                    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
                        // Verifica se o usuário é administrador (Perfil = 1 ou 3)
                        $is_admin = ($_SESSION['perfil'] == 1 || $_SESSION['perfil'] == 3);

                        echo '<header class="p-3 mb-3 border-bottom">
                                <div class="dropdown text-end me-5">
                                    <a href="#" class="d-block link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="https://github.com/mdo.png" alt="Perfil" width="32" height="32" class="rounded-circle"> ' . htmlspecialchars($_SESSION['nome']) . '
                                    </a>
                                    <ul class="dropdown-menu text-small">';

                        if ($is_admin) {
                            // Opções para administradores
                            echo '<li><a class="dropdown-item" href="paineladmin.php">Painel de administração</a></li>';
                            echo '<li><a class="dropdown-item" href="add_tool.php">Adicionar Ferramenta</a></li>';
                            echo '<li><a class="dropdown-item" href="add_categoria.php">Adicionar Categoria</a></li>';
                            echo '<li><hr class="dropdown-divider"></li>';
                        }

                        // Opções para todos os utilizadores
                        echo '<li><a class="dropdown-item" href="minha_conta.php">Minha conta</a></li>';
                        echo '<li><a class="dropdown-item" href="mensagem.php">Minha mensagens</a></li>';
                        echo '<li><hr class="dropdown-divider"></li>';


                        // Opção para terminar a sessão
                        echo '<li><a class="dropdown-item" href="logout.php">Terminar Sessão</a></li>
                                    </ul>
                                </div>
                            </header>';
                    } else {
                        echo "<a href='login.php' class='btn btn-outline-success me-2'>Login</a>";
                        echo "<a href='registo_user.php' class='btn btn-info'>Registo</a>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <main class="container mt-4">