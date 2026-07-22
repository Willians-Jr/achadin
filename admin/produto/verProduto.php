<?php
// 1. Inicia a sessão para saber quem está logado
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Conexão com o Banco de Dados do XAMPP
$host = "localhost";
$usuarioDb = "root"; 
$senhaDb = "";       
$nomeBanco = "achadin";

$conexao = new mysqli($host, $usuarioDb, $senhaDb, $nomeBanco);

if ($conexao->connect_error) {
    die("Falha na conexão com o banco: " . $conexao->connect_error);
}

// 3. Pega o ID do produto vindo da URL (?id=X)
if (isset($_GET['id'])) {
    $idProdutoAtual = intval($_GET['id']); 
} else {
    $idProdutoAtual = 1; 
}

// 4. Pega o ID do usuário logado na sessão
if (isset($_SESSION['idUsuario'])) {
    $idUsuarioLogado = intval($_SESSION['idUsuario']);
} else {
    $idUsuarioLogado = 1; // ID padrão para testes caso não tenha ninguém logado
}

// 5. SALVA NO BANCO: Ajustado para o padrão idUsuario e idProduto
$sqlInsert = "INSERT INTO historicoclique (idUsuario, idProduto) VALUES ($idUsuarioLogado, $idProdutoAtual)";
$conexao->query($sqlInsert);

// 6. BUSCA O HISTÓRICO: Pega os últimos 3 produtos que o usuário visitou
$sqlSelect = "SELECT idProduto FROM historicoclique WHERE idUsuario = $idUsuarioLogado ORDER BY dataClique DESC LIMIT 3";
$resultado = $conexao->query($sqlSelect);

$produtosVisitados = [];
while ($linha = $resultado->fetch_assoc()) {
    $produtosVisitados[] = $linha['idProduto'];
}

if (empty($produtosVisitados)) {
    $produtosVisitados[] = $idProdutoAtual;
}

// Transforma a lista em string (ex: "2,1,4")
$listaIds = implode(",", $produtosVisitados);

// 7. EXECUTA O PYTHON
$comandoPython = "C:/Users/uept02-user/AppData/Local/Python/pythoncore-3.14-64/python.exe"; 
$scriptPython = "C:/xampp/htdocs/achadin/admin/produto/filtragem.py"; 

$comandoCompleto = "$comandoPython $scriptPython $listaIds 2>&1";
$saida = shell_exec($comandoCompleto);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Loja Virtual - Detalhes do Produto</title>
</head>
<body>
    <h1>Página do Produto (ID Atual: <?php echo $idProdutoAtual; ?>)</h1>
    <hr>
    
    <h2>Recomendações da nossa IA:</h2>
    <pre><?php echo utf8_encode($saida); ?></pre>
</body>
</html>