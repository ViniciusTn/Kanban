<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);

    if (empty($nome) || empty($email)) {
        echo "<script>alert('Preencha todos os campos!'); history.back();</script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('E-mail inválido!'); history.back();</script>";
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email) VALUES (?, ?)");
    $stmt->bind_param("ss", $nome, $email);

    if ($stmt->execute()) {
        header("Location: sucesso.html");
        exit;
    } else {
        echo "<script>alert('Erro ao cadastrar usuário!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de Usuário</h1>
    <form method="POST" action="">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br>

        <label>E-mail:</label><br>
        <input type="email" name="email" required><br>

        <button type="submit">Cadastrar</button>
    </form>

    <a href="index.html">Voltar ao menu principal</a>
</body>
</html>