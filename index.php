<?php
require_once __DIR__ . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

// ==========================================
// 🚨 INÍCIO DA ADIÇÃO: MOTOR DE RECOMENDAÇÃO
// ==========================================
if (isset($_GET['id'])) {
    $idProdutoAtual = intval($_GET['id']); 
    $idUsuarioLogado = isset($_SESSION['idUsuario']) ? intval($_SESSION['idUsuario']) : 1;
    
    // Grava o clique no histórico
    $sqlInsert = "INSERT INTO historicoclique (idUsuario, idProduto) VALUES ($idUsuarioLogado, $idProdutoAtual)";
    mysqli_query($conexao, $sqlInsert);
}

// Resgata os últimos 5 produtos que o usuário clicou (ATUALIZADO PARA 5 ITENS)
$idUsuarioLogado = isset($_SESSION['idUsuario']) ? intval($_SESSION['idUsuario']) : 1;
$sqlSelect = "SELECT idProduto FROM historicoclique WHERE idUsuario = $idUsuarioLogado ORDER BY dataClique DESC LIMIT 5";
$resSelect = mysqli_query($conexao, $sqlSelect);

$idsHistorico = [];
while ($row = mysqli_fetch_assoc($resSelect)) {
    $idsHistorico[] = $row['idProduto'];
}

$recomendacoes = [];

if (!empty($idsHistorico)) {
    // Busca os dados e categorias dos produtos visitados para extrair palavras-chave
    $placeholders = implode(',', array_fill(0, count($idsHistorico), '?'));
    $sqlPalavras = "SELECT p.nomeProduto, c.nomeCategoria 
                    FROM produto p 
                    JOIN categoria c ON p.idCategoria = c.idCategoria 
                    WHERE p.idProduto IN ($placeholders)";
                    
    $stmtPalavras = mysqli_prepare($conexao, $sqlPalavras);
    $tipos = str_repeat('i', count($idsHistorico));
    mysqli_stmt_bind_param($stmtPalavras, $tipos, ...$idsHistorico);
    mysqli_stmt_execute($stmtPalavras);
    $resPalavras = mysqli_stmt_get_result($stmtPalavras);
    
    $termosBusca = [];
    while ($prod = mysqli_fetch_assoc($resPalavras)) {
        $termosBusca[] = $prod['nomeCategoria'];
        $partesNome = explode(' ', $prod['nomeProduto']);
        if (!empty($partesNome[0])) {
            $termosBusca[] = $partesNome[0]; // Pega a primeira palavra (Ex: "Shampoo", "Papel")
        }
    }
    
    $termosBusca = array_unique(array_filter($termosBusca));
    
    if (!empty($termosBusca)) {
        // Constrói a query para buscar produtos similares que NÃO sejam os mesmos já clicados recentemente
        $sqlRecomenda = "SELECT * FROM produto WHERE (";
        $condicoes = [];
        foreach ($termosBusca as $termo) {
            $condicoes[] = "nomeProduto LIKE ?";
        }
        $sqlRecomenda .= implode(' OR ', $condicoes) . ")";
        
        $sqlRecomenda .= " AND idProduto NOT IN ($placeholders) ORDER BY RAND() LIMIT 5";
        
        $stmtRecomenda = mysqli_prepare($conexao, $sqlRecomenda);
        
        $params = [];
        foreach ($termosBusca as $termo) {
            $params[] = "%" . $termo . "%";
        }
        foreach ($idsHistorico as $id) {
            $params[] = $id;
        }
        
        $tiposRecomenda = str_repeat('s', count($termosBusca)) . str_repeat('i', count($idsHistorico));
        mysqli_stmt_bind_param($stmtRecomenda, $tiposRecomenda, ...$params);
        mysqli_stmt_execute($stmtRecomenda);
        $resRecomenda = mysqli_stmt_get_result($stmtRecomenda);
        
        while ($rec = mysqli_fetch_assoc($resRecomenda)) {
            $recomendacoes[] = $rec;
        }
    }
}

// Se não houver histórico ou recomendações suficientes, preenche com produtos aleatórios
if (count($recomendacoes) < 5) {
    $notInSql = "";
    $paramsFallback = [];
    $tiposFallback = "";
    
    if (!empty($idsHistorico)) {
        $placeholders = implode(',', array_fill(0, count($idsHistorico), '?'));
        $notInSql = "WHERE idProduto NOT IN ($placeholders)";
        $paramsFallback = $idsHistorico;
        $tiposFallback = str_repeat('i', count($idsHistorico));
    }
    
    $limiteRestante = 5 - count($recomendacoes);
    $sqlFallback = "SELECT * FROM produto $notInSql ORDER BY RAND() LIMIT $limiteRestante";
    
    $stmtFallback = mysqli_prepare($conexao, $sqlFallback);
    if (!empty($paramsFallback)) {
        mysqli_stmt_bind_param($stmtFallback, $tiposFallback, ...$paramsFallback);
    }
    mysqli_stmt_execute($stmtFallback);
    $resFallback = mysqli_stmt_get_result($stmtFallback);
    
    while ($fallbackProd = mysqli_fetch_assoc($resFallback)) {
        $recomendacoes[] = $fallbackProd;
    }
}
// ==========================================
// 🚨 FIM DA ADIÇÃO
// ==========================================
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Achados - Página Inicial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&amp;display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
    <style>
        .link-produto-vitrine { text-decoration: none; color: inherit; display: block; }
        .link-produto-vitrine:hover h6 { color: #0d6efd; }
    </style>
</head>
<body>
    <main>

<?php require_once ROOT_PATH . '/includes/header.php'; ?>

   <header class="bannerIndex ">
 
 <div class="container banner">
 
        <div class="row align-items-center">
 
            <div class="col-12 col-lg-6 mt-5 mt-lg-0">
 
                <h1 class="display-5 fw-bold text-white mb-4">
                    Cupons de desconto <br>
                    das <span class="text-warning">melhores lojas</span>
                </h1>
 
                <p class="text-white mb-4">
                    Economize nas suas compras com os melhores cupons
                    e ofertas das principais lojas online.
                </p>
 
                <div class="d-flex flex-wrap gap-4">
 
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-outlined text-warning me-2">
                            verified
                        </span>
                        <small class="text-white beneficio">
                            Cupons<br>verificados
                        </small>
                    </div>
 
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-outlined text-warning me-2">
                            local_offer
                        </span>
                        <small class="text-white beneficio">
                            Melhores<br>descontos
                        </small>
                    </div>
 
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-outlined text-warning me-2">
                            update
                        </span>
                        <small class="text-white beneficio">
                            Ofertas<br>atualizadas
                        </small>
                    </div>
 
                    <div class="d-flex align-items-center">
                        <span class="material-symbols-outlined text-warning me-2">
                            lock
                        </span>
                        <small class="text-white beneficio">
                            100% Grátis<br>e seguro
                        </small>
                    </div>
 
                </div>
 
            </div>
 
            <div class="col-12 col-lg-6 mt-5 mt-lg-0">
 
               
               <div class="row align-items-center justify-content-center">
 
                    
                    <div class="col-12 col-md-5">
                        <img src="/achadin/assets/IMG/Sacola.png" class="img-fluid banner-img" alt="Sacola Banner">
                    </div>
 
                    <div class="col-12 col-md-7">
                    
                        <div class="porcentagem text-center">
 
                            <p class="mb-1 text-secondary fw-semibold">
                                Economize até
                            </p>
 
                            <h2 class="display-1 fw-bold text-primary mb-3">
                                70%
                            </h2>
 
                            <span class="economize">
                                em suas compras online
                            </span>
 
                        </div>
                    </div>
 
                </div>
 
            </div>
 
        </div>
 
    </div>
 
</header>
 
<div class="container mt-5">
 
 
    <div class="card shadow-lg border-0 rounded-4">
 
 
        <div class="card-body">
 
 
            <div class="d-flex justify-content-between mb-3">
 
 
                <h6>Lojas em destaque</h6>
 
 
                <a href="#">Ver todas</a>
 
 
            </div>
 
 
            <div class="row g-1">
 
                                    <div class="col-md-3">
                        <div class="card p-3 text-center h-100">
                            Kalunga                        </div>
                    </div>
                                    <div class="col-md-3">
                        <div class="card p-3 text-center h-100">
                            Magazine Luiza                        </div>
                    </div>
               
            </div>
 
 
        </div>
 
 
    </div>
 
 
</div>
 
<div class="container my-4">
 
 
    <div class="d-flex flex-wrap gap-3">
 
        <button class="btn btn-light border">
            Todos os filtros
        </button>
 
 
        <select class="form-select w-auto">
            <option>Preços</option>
        </select>
 
 
        <select class="form-select w-auto">
            <option>Modelos</option>
        </select>
 
        <select name="categoriaProduto" id="categoriaProduto" class="form-select w-auto">
            <option value="" disabled="" selected="">Categorias</option><option value="2">
                    Cosméticos</option><option value="1">
                    Produto de Limpeza</option><option value="3">
                    Tecnologia</option><option value="4">
                    Uso cotidiano</option>        </select>
 
    </div>
 
 
</div>
 
<style>
  .card {
    border-radius: 15px;
    overflow: hidden;
}
 
.img-produto {
    width: 100%;
    height: 220px;
    object-fit: contain;
    background: #fff;
    padding: 20px;
}
</style>
<div class="container my-4">
    <h5 class="mb-3 text-secondary fw-semibold">Recomendados para você</h5>
    
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">
 
        <?php 
        if (!empty($recomendacoes)) {
            foreach ($recomendacoes as $produto) { 
                // Define uma imagem padrão caso o banco esteja vazio
                $imagemFinal = !empty($produto['fotoProduto']) ? htmlspecialchars($produto['fotoProduto']) : 'sem-imagem.png';
                ?>
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        
                        <a href="<?= htmlspecialchars($produto['linkAfiliado']) ?>" 
                           target="_blank" 
                           onclick="window.location.href='?id=<?= $produto['idProduto'] ?>';" 
                           class="link-produto-vitrine">
                           
                            <img src="/achadin/<?= $imagemFinal ?>" class="card-img-top img-produto" alt="<?= htmlspecialchars($produto['nomeProduto']) ?>">
         
                            <div class="card-body">
         
                                <h6><?= htmlspecialchars($produto['nomeProduto'], ENT_QUOTES, 'UTF-8') ?></h6>
         
                            </div>
                        </a>
     
                    </div>
                </div>
                <?php 
            } 
        } else {
            echo "<div class='col-12'><p class='text-muted italic'>Nenhuma recomendação disponível no momento.</p></div>";
        }
        ?>
       
    </div>
 
 
</div>
 
</main>
 
 
 
    <meta charset="UTF-8">
 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>Top Achados - Footer</title>
 
 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 
 
    <link rel="stylesheet" href="/achadin/assets/CSS/style.css">
 
 
 
 
 
 
 
    <footer class="footer py-4">
 
        <div class="container">
 
            <div class="row align-items-start g-4">
 
 
                <div class="col-12 col-md-6 col-lg-6">
 
 
                    <a class="navbar-brand logoA d-flex align-items-center gap-2" href="/achadin/index.php">
 
 
                        <img src="/achadin/assets/IMG/Catavento.png" class="imgLogo" alt="Logo Top Achados">
 
 
                        <div class="logoTexto">
 
                            <span class="logo">
                                Top
                            </span>
 
                            <span class="logo">
                                Achados
                            </span>
 
                        </div>
 
                    </a>
 
 
                    <p class="footer-slogan mt-3 mb-0">
 
                        O que você busca está aqui!
 
                    </p>
 
                </div>
 
 
                <div class="col-12 col-md-3 col-lg-3 footer-column">
 
 
                    <h3 class="h6 text-uppercase fw-bold mb-3">
 
                        FrontEnd
 
                    </h3>
 
 
                    <p class="mb-0">
 
                        Nomes dos responsáveis
 
                    </p>
 
                </div>
 
 
                <div class="col-12 col-md-3 col-lg-3 footer-column">
 
 
                    <h3 class="h6 text-uppercase fw-bold mb-3">
 
                        BackEnd
 
                    </h3>
 
 
                    <p class="mb-0">
 
                        Nomes dos responsáveis
 
                    </p>
 
                </div>
 
 
            </div>
 
        </div>
 
    </footer>
 
 
 
 
 
 
</body></html>