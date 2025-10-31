<?php
include("conexao.php");

if (!isset($_GET["id"])) {
    die("ID da tarefa não informado.");
}

$id = $_GET["id"];
$tarefa = $conn->query("SELECT * FROM tarefas WHERE id = $id")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $descricao = $_POST["descricao"];
    $setor = $_POST["setor"];
    $prioridade = $_POST["prioridade"];
    $status = $_POST["status"];

    $stmt = $conn->prepare("UPDATE tarefas SET descricao=?, setor=?, prioridade=?, status=? WHERE id=?");
    $stmt->bind_param("ssssi", $descricao, $setor, $prioridade, $status, $id);
    $stmt->execute();
    header("Location: gerenciar_tarefas.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Editar Tarefa</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Editar Tarefa</h1>
<form method="POST">
    <label>Descrição:</label><br>
    <textarea name="descricao" required><?= htmlspecialchars($tarefa['descricao']) ?></textarea><br>
    <label>Setor:</label><br>
    <input type="text" name="setor" value="<?= htmlspecialchars($tarefa['setor']) ?>" required><br>
    <label>Prioridade:</label><br>
    <select name="prioridade" required>
        <option value="baixa" <?= $tarefa['prioridade']=='baixa'?'selected':'' ?>>Baixa</option>
        <option value="média" <?= $tarefa['prioridade']=='média'?'selected':'' ?>>Média</option>
        <option value="alta" <?= $tarefa['prioridade']=='alta'?'selected':'' ?>>Alta</option>
    </select><br>
    <label>Status:</label><br>
    <select name="status" required>
        <option value="a fazer" <?= $tarefa['status']=='a fazer'?'selected':'' ?>>A Fazer</option>
        <option value="fazendo" <?= $tarefa['status']=='fazendo'?'selected':'' ?>>Fazendo</option>
        <option value="pronto" <?= $tarefa['status']=='pronto'?'selected':'' ?>>Pronto</option>
    </select><br>
    <button type="submit">Salvar Alterações</button>
</form>
</body>
</html>
