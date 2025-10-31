<?php
include("conexao.php");

$usuarios = $conn->query("SELECT id, nome FROM usuarios ORDER BY nome");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario_id = $_POST["usuario_id"];
    $descricao = trim($_POST["descricao"]);
    $setor = trim($_POST["setor"]);
    $prioridade = $_POST["prioridade"];
    $status = "a fazer";

    if (empty($usuario_id) || empty($descricao) || empty($setor) || empty($prioridade)) {
        echo "<script>alert('Preencha todos os campos!'); history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO tarefas (usuario_id, descricao, setor, prioridade, status, data_cadastro) 
                            VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("issss", $usuario_id, $descricao, $setor, $prioridade, $status);

    if ($stmt->execute()) {
        header("Location: sucesso_tarefa.html");
        exit;
    } else {
        echo "<script>alert('Erro ao cadastrar tarefa!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Tarefa</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de Tarefa</h1>
    <form method="POST" action="">
        <label>Usuário Responsável:</label><br>
        <select name="usuario_id" required>
            <option value="">Selecione um usuário</option>
            <?php while ($u = $usuarios->fetch_assoc()) { ?>
                <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['nome']) ?></option>
            <?php } ?>
        </select><br>

        <label>Descrição da Tarefa:</label><br>
        <textarea name="descricao" rows="3" cols="40" required></textarea><br>

        <label>Setor:</label><br>
        <input type="text" name="setor" required><br>

        <label>Prioridade:</label><br>
        <select name="prioridade" required>
            <option value="baixa">Baixa</option>
            <option value="média">Média</option>
            <option value="alta">Alta</option>
        </select><br>

        <button type="submit">Cadastrar Tarefa</button>
    </form>

    <a href="index.html">Voltar ao menu principal</a>
</body>
</html>
