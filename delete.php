<?php
//vai incluir o ficheiro header.php que se encontra na pasta inc. 
//O require garante que o ficheiro é incluído; caso não seja encontrado, ocorrerá um erro fatar e a execução do script será interrompida.
require(__DIR__ . '/inc/header.php');

// Incluir o arquivo de configuração
include __DIR__. '/inc/config.php';

$title = 'Apagar Utilizador';  

// Conectar ao banco de dados usando PDO
$conn = connect_db();

// Verificar se o ID do utilizador foi passado
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Preparar e executar a query de exclusão
    $sql = "DELETE FROM users WHERE id = :id"; // Corrigido o nome da tabela para 'utilizador'
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        // Redirecionar para o dashboard após a exclusão
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Erro ao apagar utilizador: " . $stmt->errorInfo()[2];
    }
} else {
    echo "ID do utilizador não fornecido.";
}
?>