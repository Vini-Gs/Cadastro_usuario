<?php
// Conectar ao banco de dados
$host = 'localhost';
$db = 'clientes_db'; // Nome correto do banco de dados
$user = 'root';      // Usuário padrão do MySQL
$pass = '';          // Senha padrão (em branco no XAMPP)

$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o ID do cliente foi passado
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consultar os dados do cliente
    $sql = "SELECT * FROM clientes WHERE id = $id";
    $result = $conn->query($sql);
    $cliente = $result->fetch_assoc();

    if (!$cliente) {
        echo "Cliente não encontrado.";
        exit;
    }
} else {
    echo "ID do cliente não especificado.";
    exit;
}

// Atualizar os dados do cliente se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    // Atualizar no banco de dados
    $sql = "UPDATE clientes SET nome='$nome', telefone='$telefone', endereco='$endereco' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Cliente atualizado com sucesso!<br><br>";
        echo "<a href='cadastrar.php'>Voltar para a lista de clientes</a>";
    } else {
        echo "Erro: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #35424a;
            color: #ffffff;
            padding: 10px 0;
            text-align: center;
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="submit"] {
            padding: 10px;
            border: 1px solid #cccccc;
            border-radius: 5px;
        }

        input[type="text"]:focus {
            border-color: #35424a;
            outline: none;
        }

        input[type="submit"] {
            background-color: #35424a;
            color: #ffffff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #007bff;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #dddddd;
        }

        th, td {
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #35424a;
            color: #ffffff;
        }

        .alert {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .actions a {
            margin-right: 10px;
            color: #35424a;
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<header>
    <h1>Editar Cliente</h1>
</header>

<div class="container">
    <!-- Formulário para editar clientes -->
    <form action="editar.php?id=<?php echo $id; ?>" method="POST">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $cliente['nome']; ?>" required>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" value="<?php echo $cliente['telefone']; ?>" required>

        <label for="endereco">Endereço:</label>
        <input type="text" id="endereco" name="endereco" value="<?php echo $cliente['endereco']; ?>" required>

        <input type="submit" value="Atualizar Cliente">
    </form>

    <h2>Clientes Cadastrados:</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Ações</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['nome']; ?></td>
                <td><?php echo $row['telefone']; ?></td>
                <td><?php echo $row['endereco']; ?></td>
                <td class="actions">
                    <a href="editar.php?id=<?php echo $row['id']; ?>">Editar</a>
                    <a href="excluir.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
    
    <a href="cadastrar.php">Voltar para a lista de clientes</a>
</div>

</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>