<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
// Configuração da conexão com o banco de dados
$conexao = mysqli_connect("localhost", "root", "", "escola");

// Verifica se houve erro na conexão
if (!$conexao) {
    die("Erro na conexão: " . mysqli_connect_error());
}

// Criar tabela se não existir
$sql = "CREATE TABLE IF NOT EXISTS notas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    serie VARCHAR(20) NOT NULL,
    bimestre INT NOT NULL,
    nota1 DECIMAL(4,2),
    trabalho DECIMAL(4,2),
    nota2 DECIMAL(4,2),
    recuperacao DECIMAL(4,2),
    resultado_final DECIMAL(4,2)
)";

mysqli_query($conexao, $sql);

// Processamento do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $serie = $_POST['serie'];
    $bimestre = $_POST['bimestre'];
    $nota1 = min(9.0, floatval($_POST['nota1']));
    $trabalho = min(7.0, floatval($_POST['trabalho']));
    $nota2 = min(9.0, floatval($_POST['nota2']));
    
    // Calcula a média antes da recuperação
    $media = ($nota1 + $trabalho + $nota2) / 3;
    
    // Verifica se precisa de recuperação
    $recuperacao = 0;
    if ($media < 6.0) {
        $recuperacao = floatval($_POST['recuperacao']);
        $resultado_final = ($media + $recuperacao) / 2;
    } else {
        $resultado_final = $media;
    }
    
    // Insere os dados no banco
    $sql = "INSERT INTO notas (nome, serie, bimestre, nota1, trabalho, nota2, recuperacao, resultado_final) 
            VALUES ('$nome', '$serie', $bimestre, $nota1, $trabalho, $nota2, $recuperacao, $resultado_final)";
    
    if (mysqli_query($conexao, $sql)) {
        $mensagem = "Cadastro realizado com sucesso!";
    } else {
        $mensagem = "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Alunos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
        }
        
        .container {
            background-color: #f5f5f5;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        h2 {
            color: #333;
            text-align: center;
        }
        
        .form-group {
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }
        
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        
        .mensagem {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
            text-align: center;
        }
        
        .sucesso {
            background-color: #dff0d8;
            color: #3c763d;
        }
        
        .erro {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Cadastro de Alunos</h2>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Nome do Aluno:</label>
                <input type="text" name="nome" required>
            </div>
            
            <div class="form-group">
                <label>Série:</label>
                <input type="text" name="serie" required>
            </div>
            
            <div class="form-group">
                <label>Bimestre:</label>
                <input type="number" name="bimestre" min="1" max="4" required>
            </div>
            
            <div class="form-group">
                <label>Nota 1 (máx. 9,0):</label>
                <input type="number" name="nota1" step="0.1" min="0" max="9" required>
            </div>
            
            <div class="form-group">
                <label>Trabalho (máx. 7,0):</label>
                <input type="number" name="trabalho" step="0.1" min="0" max="7" required>
            </div>
            
            <div class="form-group">
                <label>Nota 2 (máx. 9,0):</label>
                <input type="number" name="nota2" step="0.1" min="0" max="9" required>
            </div>
            
            <div class="form-group">
                <label>Recuperação (se necessário):</label>
                <input type="number" name="recuperacao" step="0.1" min="0" max="10">
            </div>
            
            <input type="submit" value="Cadastrar">
        </form>
        
        <?php if (isset($mensagem)): ?>
            <div class="mensagem <?php echo strpos($mensagem, 'sucesso') !== false ? 'sucesso' : 'erro'; ?>">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
</body>
</html>