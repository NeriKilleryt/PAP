<?php
require __DIR__ . '/inc/config.php';
$conn = connect_db();

$sql = "SELECT * FROM mensagens ORDER BY data_envio DESC LIMIT 5";
$stmt = $conn->query($sql);

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($row['id']) . "</td>";
    echo "<td>" . htmlspecialchars($row['nome']) . "</td>";
    echo "<td>" . htmlspecialchars($row['email']) . "</td>";
    echo "<td>" . htmlspecialchars($row['mensagem']) . "</td>";
    echo "<td>" . htmlspecialchars($row['data_envio']) . "</td>";
    echo "</tr>";
}
?>