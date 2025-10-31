<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"])) {
    $id = $_POST["id"];
    $conn->query("DELETE FROM tarefas WHERE id = $id");
}

header("Location: gerenciar_tarefas.php");
exit;
?>
