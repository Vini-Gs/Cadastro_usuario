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

// Excluir cliente
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar a query para excluir o cliente
    $sql = "DELETE FROM clientes WHERE id = $id";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Cliente excluído com sucesso!";
    } else {
        $message = "Erro ao excluir cliente: " . $conn->error;
    }
}

// Listar clientes cadastrados
$sql = "SELECT * FROM clientes";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Cliente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilo similar ao cadastrar.php */
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

        .actions a {
            margin-right: 10px;
            color: #35424a;
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        .btn-voltar {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #35424a;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-voltar:hover {
            background-color: #007bff;
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
    </style>
</head>
<body>

<header>
    <h1>Excluir Cliente</h1>
</header>

<div class="container">
    <?php if (isset($message)): ?>
        <div class="alert <?php echo strpos($message, 'sucesso') !== false ? 'success' : 'error'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <h2>Clientes Cadastrados:</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Telefone</th>
            <th>Endereço</th>
            <th>Ações</th>
        </tr>

        <?php if ($result && $result->num_rows > 0): ?>
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
        <?php else: ?>
            <tr>
                <td colspan="5">Nenhum cliente encontrado.</td>
            </tr>
        <?php endif; ?>
    </table>

    <a href="cadastrar.php" class="btn-voltar">Voltar para a lista de clientes</a>
</div>

</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>
