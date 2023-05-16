<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Usuário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Cadastro de Usuário</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="mb-3">
                <label for="username" class="form-label">Usuário:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Senha:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Senha:</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="mb-3">
                <input type="submit" class="btn btn-primary" value="Cadastrar">
            </div>
        </form>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];

            if ($password != $confirm_password) {
                echo '<p class="text-danger">As senhas não coincidem.</p>';
            } else {
          
             $host = "localhost";
             $username = "root";
             $password = "";
             $dbname = "tarefas";

                $conexao = new mysqli($host, $username, $password, $dbname);
                if ($conexao->connect_error) {
                    die("Falha na conexão com o banco de dados: " . $conexao->connect_error);
                }

                $query = "SELECT * FROM usuario WHERE username = '$username'";
                $result = $conexao->query($query);
                if ($result->num_rows > 0) {
                    echo '<p class="text-danger">Este usuário já está cadastrado.</p>';
                } else {
   
                    $query = "INSERT INTO usuario (username, password) VALUES ('$username', '$password')";
                    if ($conexao->query($query) === TRUE) {
                        echo '<p class="text-success">Usuário cadastrado com sucesso!</p>';
                    } else {
                        echo '<p class="text-danger">Erro ao cadastrar o usuário.</p>';
                    }
                }

                $conexao->close();
            }
        }
        ?>
        <p>Já possui uma conta? <a href="login.php">Faça login</a></p>
    </div>

</body>
</html>