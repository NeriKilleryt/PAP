<?php
include __DIR__ . '/inc/config.php';
$conn = connect_db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $acao = isset($_POST['acao']) ? $_POST['acao'] : '';

    if ($id > 0 && in_array($acao, ['marcar_vista', 'eliminar'])) {
        try {
            if ($acao === 'marcar_vista') {
                $sql = "UPDATE mensagens SET status = 1 WHERE id = :id";
            } elseif ($acao === 'eliminar') {
                $sql = "DELETE FROM mensagens WHERE id = :id";
            }
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erro ao processar a ação: " . $e->getMessage());
        }
    }
}

header('Location: paineladmin.php');
exit;
?>