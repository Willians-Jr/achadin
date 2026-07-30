<?php
/*
|--------------------------------------------------------------------------
| TOP ACHADOS - PÁGINA DE CATEGORIAS
|--------------------------------------------------------------------------
*/

require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';

$categorias = [


    [
        "nome" => "Eletrônicos",
        "ofertas" => "1562",
        "icone" => "💻"
    ],


    [
        "nome" => "Informática",
        "ofertas" => "1240",
        "icone" => "🖥️"
    ],


    [
        "nome" => "Celulares",
        "ofertas" => "987",
        "icone" => "📱"
    ],


    [
        "nome" => "Games",
        "ofertas" => "756",
        "icone" => "🎮"
    ],


    [
        "nome" => "Eletrodomésticos",
        "ofertas" => "842",
        "icone" => "🧺"
    ],


    [
        "nome" => "Casa e Decoração",
        "ofertas" => "635",
        "icone" => "🏠"
    ],


    [
        "nome" => "Moda",
        "ofertas" => "1123",
        "icone" => "👗"
    ],


    [
        "nome" => "Beleza e Saúde",
        "ofertas" => "823",
        "icone" => "💄"
    ],


    [
        "nome" => "Esportes",
        "ofertas" => "542",
        "icone" => "⚽"
    ],


    [
        "nome" => "Automotivo",
        "ofertas" => "312",
        "icone" => "🚗"
    ],


    [
        "nome" => "Livros",
        "ofertas" => "432",
        "icone" => "📖"
    ],


    [
        "nome" => "Bebês",
        "ofertas" => "296",
        "icone" => "👶"
    ],


    [
        "nome" => "Pet Shop",
        "ofertas" => "376",
        "icone" => "🐾"
    ],


    [
        "nome" => "Supermercado",
        "ofertas" => "234",
        "icone" => "🛒"
    ],


    [
        "nome" => "Viagens",
        "ofertas" => "256",
        "icone" => "✈️"
    ]


];


?>


<!DOCTYPE html>
<html lang="pt-BR">


<head>


    <meta charset="UTF-8">


    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Categorias | Top Achados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/categoria.css">


</head>


<body>


    <!-- =====================================================
         HEADER
    ====================================================== -->


    <?php require_once ROOT_PATH . '/includes/header.php'; ?>




    <!-- =====================================================
         CONTEÚDO PRINCIPAL
    ====================================================== -->


    <main class="main-container">




        <!-- BREADCRUMB -->


        <div class="breadcrumb">


            <a href="#">
                Home
            </a>


            <span>
                ›
            </span>


            <span>
                Categorias
            </span>


        </div>




        <!-- TÍTULO -->


        <section class="page-heading">


            <h1>
                Categorias
            </h1>


            <p>
                Explore as melhores ofertas por categoria.
            </p>


        </section>




        <!-- CATEGORIAS -->


        <section class="categories-grid">




            <?php foreach ($categorias as $categoria): ?>


                <a href="#" class="category-card">




                    <div class="category-icon">


                        <?= $categoria["icone"] ?>


                    </div>




                    <h2>


                        <?= $categoria["nome"] ?>


                    </h2>




                    <p>


                        <?= $categoria["ofertas"] ?> Ofertas


                    </p>




                </a>


            <?php endforeach; ?>




        </section>




        <!-- BOTÃO -->


        <a href="#" class="all-categories-button">


            <span>
                Ver todas as categorias
            </span>


            <span class="arrow">
                →
            </span>


        </a>




    </main>

 <?php require_once ROOT_PATH . '/includes/footer.php';?>


</body>


</html>
