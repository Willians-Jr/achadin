<?php
   require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';
?>



<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TopAchados - Produtos </title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- CSS do menu -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">

    <!-- CSS da página -->
    <link rel="stylesheet" href="<?= BASE_URL ?>produtos.css">

    <!-- Fontes -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
</head>

<body>


 <?php require_once ROOT_PATH . '/includes/header.php'; ?>
<div class="container py-5">

  

    <h1 class="fw-bold display-5">Produtos</h1>

    <p class="text-secondary">
        Descubra ofertas e cupons para os produtos mais desejados.
    </p>

    <div class="d-flex gap-3 flex-wrap my-4">

        <button class="btn btn-primary rounded-pill">
            Em Alta
        </button>

        <button class="btn btn-outline-secondary rounded-pill">
            Eletrônicos
        </button>

        <button class="btn btn-outline-secondary rounded-pill">
            Informática
        </button>

        <button class="btn btn-outline-secondary rounded-pill">
            Smartphones
        </button>

        <button class="btn btn-outline-secondary rounded-pill">
            Games
        </button>

    </div>

    <div class="row g-4">
<div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
    <div class="card h-100">

        <!-- Área da imagem -->
       <div class="position-relative">

    <img src="../img/iphone.jpg"
         class="card-img-top img-fluid p-3"
         alt="iPhone 16">

    <!-- Ícones -->
    <div class="position-absolute top-0 end-0 p-3 d-flex flex-column gap-2">

        <!-- Favorito -->
           <a href="#" class="text-dark">
                <i class="bi bi-heart fs-4"><span class="material-symbols-outlined"> favorite </span></i>
            </a>


        <!-- Compartilhar -->
        
<a href="#" class="text-dark"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-share" viewBox="0 0 16 16">
  <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5m-8.5 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m11 5.5a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3"/>
</svg></a>

    </div>

</div>
        <div class="card-body">
            <h5 class="fw-bold">iPhone 16</h5>

            <p class="text-secondary">
                A partir de R$ 5.489
            </p>

            <span class="badge bg-success">Até 10% OFF</span>
            <span class="badge bg-success-subtle text-success">
                Até 5% Cashback
            </span>

        </div>

    </div>
</div>

       <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <div class="card h-100">
                <img src="imagens/galaxy-s25.png"    class="card-img-top img-fluid p-3">

                <div class="card-body">

                    <h5 class="fw-bold">Galaxy S25</h5>

                    <p class="text-secondary">
                        A partir de R$ 4.999
                    </p>

                    <span class="badge bg-success">Até 8% OFF</span>
                    <span class="badge bg-success-subtle text-success">Até 3% Cashback</span>

                </div>

            </div>

        </div>

     <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
            <div class="card h-100">

                <img src="imagens/notebook.png"   class="card-img-top img-fluid p-3">

                <div class="card-body">

                    <h5 class="fw-bold">Notebook Dell</h5>

                    <p class="text-secondary">
                        A partir de R$ 3.899
                    </p>

                    <span class="badge bg-success">Até 12% OFF</span>
                    <span class="badge bg-success-subtle text-success">Até 4% Cashback</span>

                </div>

            </div>

        </div>

      <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">

            <div class="card h-100">

                <img src="imagens/ps5.png"    class="card-img-top img-fluid p-3">

                <div class="card-body">

                    <h5 class="fw-bold">PlayStation 5</h5>

                    <p class="text-secondary">
                        A partir de R$ 3.499
                    </p>

                    <span class="badge bg-success">Até 5% OFF</span>
                    <span class="badge bg-success-subtle text-success">Até 2% Cashback</span>

                </div>

            </div>

        </div>

    </div>
<div class="text-center mt-5">
 <button class="btn-ver-produtos">
    <span>Ver todos os produtos</span>
    <span class="seta">→</span>
</button>
</div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>