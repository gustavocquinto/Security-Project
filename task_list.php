<?php

require_once 'funcoes.php';

checkAuthentication();


$host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tarefas";


$conexao = new mysqli($host, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['addTask'])) {
    $descricao = $_POST['descricao'];
    addTask($descricao, $_SESSION['user_id']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['deleteTask'])) {
    $taskId = $_POST['taskId'];
    deleteTask($taskId, $_SESSION['user_id']);
}

// Verificacao de envio toggleTaskStatus
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['completed'])) {
 $taskId = $_POST['taskId'];
 $completed = $_POST['completed'] == 1 ? 0 : 1;
 toggleTaskStatus($taskId, $_SESSION['user_id'], $completed);
}

// list tarefas 
$userId = $_SESSION['user_id'];
$sql = "SELECT * FROM tasks WHERE user_id = '$userId'";
$result = $conexao->query($sql);

$tasks = array();

if ($result->num_rows > 0) {
  
    while ($row = $result->fetch_assoc()) {
        $tasks[] = $row;
    }
}

$conexao->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
 <div class = "container">
 <h1>Lista de Tarefas</h1>
    <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <div class="mb-3">
            <label for="descricao" class="form-label">Descrição da tarefa</label>
            <input type="text" name="descricao" id="descricao" class="form-control" required>
        </div>
        <button type="submit" name="addTask" class="btn btn-primary">Adicionar Tarefa</button>
    </form>

    <h2>Tarefas: </h2>
    <ul class="list-group">
        <?php foreach ($tasks as $task): ?>
         <li class="list-group-item alert-light">
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
              <input type="hidden" name="taskId" value="<?php echo $task['id']; ?>">
              <input type="hidden" name="completed" value="<?php echo $task['completed']; ?>">
              <input type="checkbox" <?php if ($task['completed'] == 1) { echo 'checked'; } ?> onchange="this.form.submit()">
              <span <?php if ($task['completed'] == 1) { echo 'style="text-decoration: line-through; "'; } ?>><?php echo $task['descricao']; ?></span>

                <?php if ($task['completed'] == 1) { echo '<span style="color: green;">Concluída</span>'; } ?>
                <?php if ($task['completed'] == 0) { echo '<span style="color: red;"> Não Concluída</span>'; } ?>

              <input type="submit" name="deleteTask" value="Excluir" class="btn btn-outline-danger">
          </form>
         </li>
        <?php endforeach; ?>
    </ul>

    <form method="POST" action="logout.php">
<button type="submit" name="logout" class="btn btn-secondary mt-3">Logout</button>
</form>
        </div >
    <a href="logout">
</body>
