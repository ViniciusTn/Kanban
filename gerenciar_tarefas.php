<?php
include("conexao.php");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["id"], $_POST["status"])) {
    $id = $_POST["id"];
    $novo_status = $_POST["status"];
    $stmt = $conn->prepare("UPDATE tarefas SET status = ? WHERE id = ?");
    $stmt->bind_param("si", $novo_status, $id);
    $stmt->execute();
    header("Location: gerenciar_tarefas.php");
    exit;
}

$afazer = $conn->query("SELECT t.*, u.nome FROM tarefas t JOIN usuarios u ON t.usuario_id = u.id WHERE status='a fazer'");
$fazendo = $conn->query("SELECT t.*, u.nome FROM tarefas t JOIN usuarios u ON t.usuario_id = u.id WHERE status='fazendo'");
$pronto = $conn->query("SELECT t.*, u.nome FROM tarefas t JOIN usuarios u ON t.usuario_id = u.id WHERE status='pronto'");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Gerenciamento de Tarefas</title>
<link rel="stylesheet" href="style.css">
<style>
.kanban {
  display: flex;
  justify-content: space-around;
  margin-top: 30px;
}
.coluna {
  background: #f1f1f1;
  width: 30%;
  border-radius: 10px;
  padding: 15px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
.tarefa {
  background: white;
  margin: 10px 0;
  padding: 10px;
  border-left: 6px solid #007BFF;
  border-radius: 6px;
}
.tarefa.alta { border-left-color: #dc3545; }
.tarefa.média { border-left-color: #ffc107; }
.tarefa.baixa { border-left-color: #28a745; }
form { display: inline; }
button {
  border: none;
  background: #007BFF;
  color: white;
  padding: 5px 10px;
  border-radius: 6px;
  cursor: pointer;
}
button.delete { background: #dc3545; }
button.edit { background: #28a745; }
button:hover { opacity: 0.9; }
</style>
</head>
<body>
<h1>Gerenciamento de Tarefas - Kanban</h1>

<div class="kanban">

  <div class="coluna">
    <h2>🟡 A Fazer</h2>
    <?php while ($t = $afazer->fetch_assoc()) { ?>
      <div class="tarefa <?= $t['prioridade'] ?>">
        <p><strong><?= htmlspecialchars($t['descricao']) ?></strong></p>
        <p>Setor: <?= htmlspecialchars($t['setor']) ?></p>
        <p>Prioridade: <?= $t['prioridade'] ?></p>
        <p>Usuário: <?= htmlspecialchars($t['nome']) ?></p>

        <form method="POST">
          <input type="hidden" name="id" value="<?= $t['id'] ?>">
          <select name="status">
            <option value="a fazer">A Fazer</option>
            <option value="fazendo">Fazendo</option>
            <option value="pronto">Pronto</option>
          </select>
          <button type="submit">Atualizar</button>
        </form>
        <form action="editar_tarefa.php" method="GET">
          <input type="hidden" name="id" value="<?= $t['id'] ?>">
          <button class="edit">Editar</button>
        </form>
        <form action="excluir_tarefa.php" method="POST" onsubmit="return confirm('Deseja excluir esta tarefa?');">
          <input type="hidden" name="id" value="<?= $t['id'] ?>">
          <button class="delete">Excluir</button>
        </form>
      </div>
    <?php } ?>
  </div>

 
  <div class="coluna">
    <h2>🟠 Fazendo</h2>
    <?php while ($t = $fazendo->fetch_assoc()) { ?>
      <div class="tarefa <?= $t['prioridade'] ?>">
        <p><strong><?= htmlspecialchars($t['descricao']) ?></strong></p>
        <p>Setor: <?= htmlspecialchars($t['setor']) ?></p>
        <p>Prioridade: <?= $t['prioridade'] ?></p>
        <p>Usuário: <?= htmlspecialchars($t['nome']) ?></p>

        <form method="POST">
          <input type="hidden" name="id" value="<?= $t['id'] ?>">
          <select name="status">
            <option value="a fazer">A Fazer</option>
            <option value="fazendo" selected>Fazendo</option>
            <option value="pronto">Pronto</option>
          </select>
          <button type="submit">Atualizar</button>
        </form>
        <form action="editar_tarefa.php" method="GET">
          <input type="hidden" name="id" value="<?= $t['id'] ?>">
          <button class="edit">Editar</button>
        </form>
        <form action="excluir_tarefa.php" method="POST" onsubmit="return confirm('Deseja excluir esta tarefa?');">
          <input type="hidden" name="id" value="<?= $t['id'] ?>">
          <button class="delete">Excluir</button>
        </form>
      </div>
    <?php } ?>
  </div>

  
  <div class="coluna">
    <h2>🟢 Pronto</h2>
    <?php while ($t = $pronto->fetch_assoc()) { ?>
      <div class="tarefa <?= $t['prioridade'] ?>">
        <p><strong><?= htmlspecialchars($t['descricao']) ?></strong></p>
        <p>Setor: <?= htmlspecialchars($t['setor']) ?></p>
        <p>Prioridade: <?= $t['prioridade'] ?></p>
        <p>Usuário: <?= htmlspecialchars($t['nome']) ?></p>

        <form method="POST">
          <input type="hidden" name="id" value="<?= $t['id'] ?>">
          <select name="status">
            <option value="a fazer">A Fazer</option>
            <option value="fazendo">Fazendo</option>
            <option value="pronto" selected>Pronto</option>
          </select>
          <button type="submit">Atualizar</button>
        </form>
        <form action="editar_tarefa.php" method="GET">
          <input type="hidden" name="id" value="<?= $t['id'] ?>">
          <button class="edit">Editar</button>
        </form>
        <form action="excluir_tarefa.php" method="POST" onsubmit="return confirm('Deseja excluir esta tarefa?');">
          <input type="hidden" name="id" value="<?= $t['id'] ?>">
          <button class="delete">Excluir</button>
        </form>
      </div>
    <?php } ?>
  </div>
</div>

<a href="index.html">Voltar ao menu principal</a>
</body>
</html>
