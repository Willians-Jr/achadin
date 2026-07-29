<?php
require_once __DIR__ . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
$pesquisa="";

//  SEGURO: Usando Prepared Statements
$pesquisa = "";
if (isset($_GET['nomeProduto'])){
  $pesquisa = trim($_GET['nomeProduto']);
}

$sqlProduto = "SELECT * FROM produto WHERE nomeProduto LIKE ? ORDER BY nomeProduto";
$stmt = mysqli_prepare($conexao, $sqlProduto);

$termo = "%" . $pesquisa . "%";
mysqli_stmt_bind_param($stmt, "s", $termo);
mysqli_stmt_execute($stmt);

$resultadoProduto = mysqli_stmt_get_result($stmt);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Top Achados - Página Inicial</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
</head>
<body>
    <main>
   <?php require_once ROOT_PATH . '/includes/header.php'; ?>


   <!-- HEADER -->
<header class="bannerIndex ">
 
 <div class="container banner">
 
        <div class="row align-items-center">
 
            <!-- Texto -->
           
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
 
            <!-- Ícone e porcentagem -->
            
            <div class="col-12 col-lg-6 mt-5 mt-lg-0">
 
               
               <div class="row align-items-center justify-content-center">
 
                    
                    <div class="col-12 col-md-5">
                        <img src="<?= BASE_URL ?>/assets/IMG/Sacola.png"
     class="img-fluid banner-img"
     alt="Sacola Banner">
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
 
<!-- FIM HEADER -->
 
 
<!-- FIM HEADER -->

<!-- LOJAS EM DESTAQUE -->
<div class="container mt-5">
 
    <div class="card shadow-lg border-0 rounded-4">
 
        <div class="card-body">
 
            <div class="d-flex justify-content-between mb-3">
 
                <h6>Lojas em destaque</h6>
 
                <a href="#">Ver todas</a>
 
            </div>
 
            <div class="row g-3">
 
                <div class="col">
                    <div class="card p-3 text-center">
                        Shopee
                    </div>
                </div>
 
                <div class="col">
                    <div class="card p-3 text-center">
                        Mercado Livre
                    </div>
                </div>
 
                <div class="col">
                    <div class="card p-3 text-center">
                        Amazon
                    </div>
                </div>
 
            </div>
 
        </div>
 
    </div>
 
</div>
 
 
<!-- FIM LOJAS EM DESTAQUE -->
<!-- FILTROS -->
<div class="container my-4">
 
    <div class="d-flex flex-wrap gap-3">
 
        <button class="btn btn-outline-secondary">
            Todos os filtros
        </button>
 
        <select class="form-select w-auto">
            <option>Preços</option>
        </select>
 
        <select class="form-select w-auto">
            <option>Modelos</option>
        </select>
 
        <select class="form-select w-auto">
            <option>Categorias</option>
        </select>
 
    </div>
 
</div>
 
<!-- FIM FILTROS -->
<!-- PROTUTOS -->
<div class="container">
 
    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">
 
        <div class="col">
 
            <div class="card h-100">
 
                <img src="#" class="card-img-top">
 
                <div class="card-body">
 
                    <h6 class="card-title">
                        Computador Completo
                    </h6>
 
                    <h4 class="text-danger">
                        R$ 731,45
                    </h4>
 
                    <small class="text-muted">
                        Via Amazon
                    </small>
 
                </div>
 
            </div>
 
        </div>
 
        <!-- outros cards -->
 
    </div>
 
</div>

<?php require_once ROOT_PATH . '/includes/footer.php'; ?>
</main>
</body>
</html>
<script src="<?= BASE_URL ?>assets/JS/atualizarTema.js"></script>