<?php
/**
 * Estabelece uma conexão com a base de dados.
 */

$title = 'Ligar à Base de Dados';

function connect_db() {

    define('DBHOST', 'localhost');
    define('DBNAME', "wiki");
    define('DBUSERNAME', 'Neri');
    define('DBPASSWORD', '123456');

    try {
        // Criação da string DSN
        $dsn = "mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8";

        // Criação da conexão PDO
        $pdo = new PDO($dsn, DBUSERNAME, DBPASSWORD);

        // Configurar o modo de erro do PDO para exceções
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo; // Retorna o objeto PDO
    } catch (PDOException $e) {
        // Exibe mensagem de erro em caso de falha
        die("Erro ao conectar à base de dados: " . $e->getMessage());
    }
}

?>
