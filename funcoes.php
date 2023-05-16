<?php
// Config do BD
$host = "localhost";
$username = "root";
$password = "";
$dbname = "tarefas";

$conexao = new mysqli($host, $username, $password, $dbname);
if ($conexao->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
}

// Func de user autentication
function checkAuthentication() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

// Func add tarefas
function addTask($descricao, $userId) {
    global $conexao;
    $descricao = $conexao->real_escape_string($descricao);
    $sql = "INSERT INTO tasks (user_id, descricao, completed) VALUES ('$userId', '$descricao', 0)";
    if ($conexao->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// func excluir tarefa
function deleteTask($taskId, $userId) {
    global $conexao;
    $sql = "DELETE FROM tasks WHERE id = '$taskId' AND user_id = '$userId'";
    if ($conexao->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Função para marcar/desmarcar uma tarefa como concluída
function toggleTaskStatus($taskId, $userId, $completed) {
    global $conexao;
    $sql = "UPDATE tasks SET completed = '$completed' WHERE id = '$taskId' AND user_id = '$userId'";
    if ($conexao->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

function conectar()
{
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tarefas";

    $conecta = new mysqli($host, $username, $password, $dbname);
    if ($conecta->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conecta->connect_error);
    }

    return $conecta;
}
?>
