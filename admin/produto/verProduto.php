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
    <title>Vitrine de Produtos</title>
    <style>
        .vitrine { display: flex; gap: 20px; flex-wrap: wrap; padding: 20px; }
        .card-produto { border: 1px solid #ddd; padding: 15px; border-radius: 8px; width: 200px; text-align: center; }
        .link-produto { text-decoration: none; color: #333; display: block; }
        .link-produto:hover { color: #007bff; }
        .card-produto img { max-width: 100%; height: auto; border-radius: 4px; }
    </style>
</head>
<body>

    <h1>Nossos Produtos</h1>

    <div class="vitrine">
        <?php
        // CORREÇÃO: Fazemos uma nova consulta focada em trazer a lista de produtos da loja
        // ⚠️ Verifique se o nome da sua tabela de produtos é realmente 'produtos'
        $sqlProdutos = "SELECT idProduto, nomeProduto, fotoProduto FROM produto";
        $resultadoProdutos = $conexao->query($sqlProdutos);

        // Usamos a nova variável $resultadoProdutos para o laço da vitrine
        if ($resultadoProdutos && $resultadoProdutos->num_rows > 0) {
            while ($produto = $resultadoProdutos->fetch_assoc()) {
                ?>
                <div class="card-produto">
                    
                    <a href="verProduto.php?id=<?php echo $produto['idProduto']; ?>" class="link-produto">
                        
                        <img src="../../<?php echo $produto['fotoProduto']; ?>" alt="<?php echo $produto['nomeProduto']; ?>">
                        
                        <h3><?php echo $produto['nomeProduto']; ?></h3>
                        
                    </a>
                    
                </div>
                <?php
            }
        } else {
            echo "<p>Nenhum produto cadastrado no banco ainda ou erro na tabela 'produtos'.</p>";
        }
        ?>
    </div>

    <hr>
    <h2>Recomendações em tempo real:</h2>
    <pre><?php echo utf8_encode($saida); ?></pre>

</body>
</html>