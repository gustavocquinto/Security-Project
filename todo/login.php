<?php
session_start();
//verificação de userrr
if (isset($_SESSION['user_id'])) {
    header("Location: task_list.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "tarefas";

   
    $usernameInput = $_POST['username'];
    $passwordInput = $_POST['password'];



    $conexao = new mysqli($host, $username, $password, $dbname);
    if ($conexao->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
    }

    $usernameInput = $conexao->real_escape_string($usernameInput);//limpar campo
    $passwordInput = $conexao->real_escape_string($passwordInput);
    $sql = "SELECT id FROM usuario WHERE username = '$usernameInput' AND password = '$passwordInput'";
    $result = $conexao->query($sql);

    if ($result->num_rows > 0) {
    
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        header("Location: task_list.php");
        exit();
    } else {
   
        $error = "Usuário ou senha incorretos";
    }

    $conexao->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tela de Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="text-center">Tela de Login</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Usuário:</label>
                <input type="text" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
        <?php if (isset($error)) { echo "<p class='text-danger'>$error</p>"; } ?>
        <div class="text-center mt-3">
            <a href="cadastro.php" class="btn btn-link">Criar uma conta</a>
        </div>
    </div>
</body>
</html>