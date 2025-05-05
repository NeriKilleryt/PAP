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

    

    // Verifica se todos os campos estão preenchidos
    if (!empty($nome) && !empty($email) && !empty($password) && !empty($perfil) && !empty($contacto)) {
        try {
            // Conecta ao banco de dados
            $conn = connect_db();

            // Hash da senha
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Prepara a query para inserir os dados
            $sql = "INSERT INTO users (nome, email, password, perfil, data_registo, contacto, status) 
                    VALUES (:nome, :email, :password, :perfil, NOW(), :contacto, :status)";

            // Preparando a execução da consulta
            $stmt = $conn->prepare($sql);

            $data = [
                ":nome" => $nome,
                ":email" => $email,
                ":password" => $hashed_password, // Usando a senha hash
                ":perfil" => $perfil,
                ":contacto" => $contacto,
                ":status" => 'Ativo' // Define o status como "ativo"
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

                // Redireciona para o dashboard
                header("location: index.php");
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