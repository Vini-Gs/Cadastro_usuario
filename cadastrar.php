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

// Adicionar cliente
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['nome'])) {
    $nome = $_POST['nome'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];

    $sql = "INSERT INTO clientes (nome, telefone, endereco) VALUES ('$nome', '$telefone', '$endereco')";
    
    if ($conn->query($sql) === TRUE) {
        $message = "Cliente cadastrado com sucesso!";
    } else {
        $message = "Erro ao cadastrar cliente: " . $conn->error;
    }
}

// Lógica de pesquisa
$search = "";
if (isset($_POST['search'])) {
    $search = $_POST['search'];
    $sql = "SELECT * FROM clientes WHERE nome LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM clientes";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Clientes</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Estilos principais */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #35424a;
            color: #ffffff;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin: 0;
            font-size: 24px;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 30px auto;
            background: #ffffff;
            padding: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        /* Estilo do formulário */
        .form-container {
            background-color: #f4f4f4;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #35424a;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="text"] {
            background-color: #fff;
            transition: box-shadow 0.3s ease-in-out;
        }

        input[type="text"]:focus {
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
            border-color: #007bff;
        }

        input[type="submit"] {
            background-color: #35424a;
            color: white;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #007bff;
        }

        .success, .error {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            text-align: center;
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

        /* Tabela de clientes */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #dddddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #35424a;
            color: #ffffff;
        }

        td {
            background-color: #f9f9f9;
        }

        .actions a {
            margin-right: 10px;
            color: #35424a;
            text-decoration: none;
        }

        .actions a:hover {
            text-decoration: underline;
        }

        /* Pesquisa */
        .search-form {
            margin-bottom: 20px;
        }

        .search-input {
            padding: 10px;
            width: calc(100% - 110px);
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-button {
            padding: 10px;
            background-color: #35424a;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .search-button:hover {
            background-color: #007bff;
        }
    </style>
</head>
<body>

<header>
    <h1>Cadastro de Clientes</h1>
</header>

<div class="container">
    <!-- Formulário de cadastro -->
    <div class="form-container">
        <h2>Cadastrar Novo Cliente</h2>
        <?php if (isset($message)): ?>
            <div class="<?php echo strpos($message, 'sucesso') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form action="cadastrar.php" method="POST">
            <label for="nome">Nome:</label>
            <input type="text" name="nome" placeholder="Digite o nome completo" required>

            <label for="telefone">Telefone:</label>
            <input type="text" name="telefone" placeholder="Digite o telefone" required>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" placeholder="Digite o endereço" required>

            <input type="submit" value="Cadastrar">
        </form>
    </div>

    <!-- Formulário de pesquisa -->
    <h2>Pesquisar Clientes</h2>
    <form action="cadastrar.php" method="POST" class="search-form">
        <input type="text" name="search" placeholder="Digite o nome do cliente" class="search-input">
        <input type="submit" value="Pesquisar" class="search-button">
    </form>

    <!-- Tabela de clientes cadastrados -->
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

</div>

</body>
</html>

<?php
// Fechar a conexão
$conn->close();
?>
