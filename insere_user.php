<?php
// Inclua a função de conexão com o banco de dados
include __DIR__ . '/inc/config.php';

$title = 'Inserir utilizador novo';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura os dados do formulário
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $perfil = trim($_POST['perfil']);
    $contacto = trim($_POST['contacto']);
    $imagem = null; // Inicializa a variável imagem

    // Verifica se o formulário foi submetido com uma imagem
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];

        // Verifica a extensão do arquivo
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            die("Erro: Por favor, selecione um formato de arquivo válido.");
        }

        // Verifica o tamanho do arquivo - 5MB no máximo
        $maxsize = 5 * 1024 * 1024;
        if ($filesize > $maxsize) {
            die("Erro: O arquivo excede o limite de tamanho permitido.");
        }

        // Verifica o tipo MIME do arquivo
        if (in_array($filetype, $allowed)) {
            // Verifica se o arquivo existe antes de fazer o upload
            if (file_exists("upload/" . $filename)) {
                echo $filename . " já existe.";
            } else {
                if (move_uploaded_file($_FILES["photo"]["tmp_name"], "upload/" . $filename)) {
                    $imagem = "upload/" . $filename;
                    echo "Seu arquivo foi carregado com sucesso.";
                }
            }
        } else {
            echo "Erro: Há um problema ao carregar o arquivo. Por favor, tente novamente.";
        }
    }

    // Verifica se todos os campos estão preenchidos
    if (!empty($nome) && !empty($email) && !empty($password) && !empty($perfil) && !empty($contacto) && !empty($imagem)) {
        try {
            // Conecta ao banco de dados
            $conn = connect_db();

            // Hash da senha
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepara a query para inserir os dados
            $sql = "INSERT INTO users (nome, email, password, perfil, data_registo, contacto, imagem) 
                    VALUES (:nome, :email, :password, :perfil, NOW(), :contacto, :imagem)";

            // Preparando a execução da consulta
            $stmt = $conn->prepare($sql);

            $data = [
                ":nome" => $nome,
                ":email" => $email,
                ":password" => $hashed_password, // Usando a senha hash
                ":perfil" => $perfil,
                ":contacto" => $contacto,
                ":imagem" => $imagem
            ];

            // Executando a consulta
            if ($stmt->execute($data)) {
                // Cria a sessão após o registro bem-sucedido
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['loggedin'] = true; // true - indica que fez login
                $_SESSION['email'] = $email;
                $_SESSION['nome'] = $nome;
                $_SESSION['perfil'] = $perfil;
                $_SESSION['contacto'] = $contacto;
                $_SESSION['imagem'] = $imagem;

                // Redireciona para o dashboard
                header("location: dashboard.php");
                exit();
            } else {
                $errorInfo = $stmt->errorInfo();
                echo "Erro ao adicionar um utilizador. Código do erro: " . $errorInfo[0] . " - " . $errorInfo[2];
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Código de erro para violação de UNIQUE
                echo "Erro: O email já está em uso!";
            } else {
                echo "Erro: " . $e->getMessage();
            }
        }
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    echo "Acesso inválido.";
}
?>