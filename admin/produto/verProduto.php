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
$idProdutoAtual = isset($_GET['id']) ? intval($_GET['id']) : 3; // Padrão ID 3 (Shampoo CR7)

// 4. Pega o ID do usuário logado na sessão
$idUsuarioLogado = isset($_SESSION['idUsuario']) ? intval($_SESSION['idUsuario']) : 1;

// 5. SALVA NO BANCO: Histórico de cliques
$sqlInsert = "INSERT INTO historicoclique (idUsuario, idProduto) VALUES ($idUsuarioLogado, $idProdutoAtual)";
$conexao->query($sqlInsert);

// 6. BUSCA O HISTÓRICO: Pega os últimos 3 produtos visitados
$sqlSelect = "SELECT idProduto FROM historicoclique WHERE idUsuario = $idUsuarioLogado ORDER BY dataClique DESC LIMIT 3";
$resultado = $conexao->query($sqlSelect);

$produtosVisitados = [];
while ($linha = $resultado->fetch_assoc()) {
    $produtosVisitados[] = intval($linha['idProduto']);
}
if (empty($produtosVisitados)) {
    $produtosVisitados[] = $idProdutoAtual;
}

// --- LÓGICA DA IA DIRETO NO PHP (Substituindo o Python) ---
$palavrasChaveHistorico = [];
$stopwords = ['para', 'de', 'o', 'a', 'os', 'as', 'com', 'em', 'um', 'uma', 'ao', 'leite', 'do', 'da', 'seguindo', 'normas', 'impostas', 'pelo'];

// Função interna para limpar e extrair palavras do texto
function extrairPalavras($texto, $stopwords) {
    $texto = mb_strtolower($texto, 'UTF-8');
    // Remove pontuações
    $texto = preg_replace('/[^\w\s]/u', '', $texto);
    $palavras = explode(' ', $texto);
    return array_filter($palavras, function($p) use ($stopwords) {
        return strlen(trim($p)) > 2 && !in_array($p, $stopwords);
    });
}

// Coleta as palavras-chave das descrições do histórico do usuário
$listaIdsString = implode(',', $produtosVisitados);
$sqlDescricoes = "SELECT descricaoProduto FROM produto WHERE idProduto IN ($listaIdsString)";
$resDescricoes = $conexao->query($sqlDescricoes);
if ($resDescricoes) {
    while ($row = $resDescricoes->fetch_assoc()) {
        $palavrasChaveHistorico = array_merge($palavrasChaveHistorico, extrairPalavras($row['descricaoProduto'], $stopwords));
    }
}
$palavrasChaveHistorico = array_unique($palavrasChaveHistorico);

// Varre todos os outros produtos para calcular afinidade
$idsRecomendados = [];
$sqlTodos = "SELECT idProduto, descricaoProduto FROM produto";
$resTodos = $conexao->query($sqlTodos);

if ($resTodos) {
    while ($prod = $resTodos->fetch_assoc()) {
        $idAtual = intval($prod['idProduto']);
        
        // Só recomenda se NÃO estiver no histórico recente
        if (!in_array($idAtual, $produtosVisitados)) {
            $palavrasProd = extrairPalavras($prod['descricaoProduto'], $stopwords);
            
            // Conta quantas palavras em comum existem
            $interseccao = array_intersect($palavrasChaveHistorico, $palavrasProd);
            
            if (count($interseccao) > 0) {
                $idsRecomendados[] = $idAtual;
            }
        }
    }
}
// --- FIM DA LÓGICA DA IA ---
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
        $sqlProdutos = "SELECT idProduto, nomeProduto, fotoProduto, linkAfiliado FROM produto";
        $resultadoProdutos = $conexao->query($sqlProdutos);

        if ($resultadoProdutos && $resultadoProdutos->num_rows > 0) {
            while ($produto = $resultadoProdutos->fetch_assoc()) {
                ?>
                <div class="card-produto">
                    <a href="<?php echo $produto['linkAfiliado']; ?>" 
                       target="_blank" 
                       onclick="window.location.href='?id=<?php echo $produto['idProduto']; ?>';" 
                       class="link-produto">
                        
                        <img src="../../<?php echo $produto['fotoProduto']; ?>" alt="<?php echo $produto['nomeProduto']; ?>">
                        <h3><?php echo $produto['nomeProduto']; ?></h3>
                        
                    </a>
                </div>
                <?php
            }
        } else {
            echo "<p>Nenhum produto cadastrado no banco ainda.</p>";
        }
        ?>
    </div>

    <hr>
    <h2>Recomendações da IA feitas especialmente para você:</h2>

    <div class="vitrine">
        <?php
        if (!empty($idsRecomendados)) {
            $idsIAString = implode(',', $idsRecomendados);
            $sqlRec = "SELECT idProduto, nomeProduto, fotoProduto, linkAfiliado FROM produto WHERE idProduto IN ($idsIAString)";
            $resultadoRec = $conexao->query($sqlRec);

            if ($resultadoRec && $resultadoRec->num_rows > 0) {
                while ($rec = $resultadoRec->fetch_assoc()) {
                    ?>
                    <div class="card-produto" style="border-color: #007bff;"> 
                        <a href="<?php echo $rec['linkAfiliado']; ?>" 
                           target="_blank" 
                           onclick="window.location.href='?id=<?php echo $rec['idProduto']; ?>';" 
                           class="link-produto">
                            
                            <img src="../../<?php echo $rec['fotoProduto']; ?>" alt="<?php echo $rec['nomeProduto']; ?>">
                            <h3><?php echo $rec['nomeProduto']; ?></h3>
                            
                        </a>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Nenhuma recomendação disponível no momento.</p>";
            }
        } else {
            echo "<p>Nenhuma recomendação disponível no momento.</p>";
        }
        ?>
    </div>

</body>
</html>