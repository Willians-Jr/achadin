<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
$pesquisa="";

if (isset($_GET['pesquisa'])){
  $pesquisa=trim($_GET['pesquisa']);
  
}

$sqlCategorias = "SELECT * FROM categoria ORDER BY nomeCategoria";
$resCategorias = mysqli_query($conexao, $sqlCategorias);
$sql = "SELECT * FROM produto WHERE nomeProduto LIKE ?";

if (isset($_GET['categoria'])){
    $categorias = implode(",", array_map('intval', $_GET['categoria']));

    $sql .= " AND idCategoria IN ($categorias)";
}
if(isset($_GET['precoMax'])){

    $sql .= " AND precoProduto <= ?";

}
$stmt= mysqli_prepare($conexao, $sql);

$termo = "%" . $pesquisa . "%";

mysqli_stmt_bind_param($stmt, "s", $termo);
mysqli_stmt_execute($stmt);

// switch($_GET['ordenar']){

//     case 'precoASC':
//         $sql .= " ORDER BY precoProduto ASC";
//         break;

//     case 'precoDESC':
//         $sql .= " ORDER BY precoProduto DESC";
//         break;

//     case 'desconto':
//         $sql .= " ORDER BY descontoProduto DESC";
//         break;

//     case 'cashback':
//         $sql .= " ORDER BY cashbackProduto DESC";
//         break;

//     case 'recentes':
//         $sql .= " ORDER BY idProduto DESC";
//         break;

//     default:
//         $sql .= " ORDER BY nomeProduto";
// }

$resultado = mysqli_stmt_get_result($stmt);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Resultado da Pesquisa</title>
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/produto.css">
</head>
<body>
<main>
   <?php require_once ROOT_PATH . '/includes/header.php'; ?>
   <div class="container py-5">
 
    
 
    <h1 class="fw-bold display-5">Nome da Categoria</h1>
 
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
 
    <!-- NOVA ESTRUTURA -->
    <div class="row">
        
            <!-- FILTROS -->
            <aside class="col-lg-3 mb-4">
    
                <div class="card shadow-sm">
    
                    <div class="card-body">
    
                        <h5 class="fw-bold mb-4">
                            Filtros
                        </h5>
    
                        <div class="mb-4">
                            <form method="GET">
                            <label class="form-label fw-semibold">
                                Categoria
                            </label>
    
                            <?php while($categoria = mysqli_fetch_assoc($resCategorias)){ ?>

                                <div class="form-check">

                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="categoria[]"
                                        value="<?= $categoria['idCategoria'] ?>">

                                    <label class="form-check-label">
                                        <?= $categoria['nomeCategoria'] ?>
                                    </label>

                                </div>

                            <?php } ?>
    
                        </div>
    
                        <div class="mb-4">
    
                            <label class="form-label fw-semibold">
                                Faixa de preço
                            </label>
    
                            <input type="range"
                                name="preco"
                                min="0"
                                max="1000"
                                class="form-range">
    
                        </div>
    
                        <div class="mb-4">
    
                            <label class="form-label fw-semibold">
                                Cashback
                            </label>
    
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">
                                    Acima de 2%
                                </label>
                            </div>
    
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">
                                    Acima de 5%
                                </label>
                            </div>
    
                        </div>
    
                        <button class="btn btn-primary w-100" type="submit">
                            Aplicar filtros
                        </button>
                        </form>
                    </div>
    
                </div>
    
            </aside>
 
        <!-- PRODUTOS -->
        <div class="col-lg-9">
 
            <!-- ORDENAR -->
            <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
 
                <p class="text-secondary mb-2 mb-lg-0">
                    <?= mysqli_num_rows($resultado) ?> produtos encontrados
                </p>
 
                <div class="d-flex align-items-center gap-2">
 
                    <label class="fw-semibold mb-0">
                        Ordenar por
                    </label>
 
                    <select name="ordenar" class="form-select" style="width:220px;">
 
                        <option value="relevancia">Mais relevantes</option>

                        <option value="precoASC">Menor preço</option>

                        <option value="precoDESC">Maior preço</option>

                        <option value="desconto">Maior desconto</option>

                        <option value="cashback">Maior cashback</option>

                        <option value="recentes">Mais recentes</option>
                    </select>
 
                </div>
 
            </div>
 
            <!-- CARDS -->
            <div class="row g-4 ">

              <?php while ($produto = mysqli_fetch_assoc($resultado)) { ?>
 
                <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
                    <div class="card h-100">
 
                        <div class="position-relative">
 
                            <img src="<?= $produto['fotoProduto'] ?>"
                                 class="card-img-top img-fluid p-3"
                                 alt="<?= $produto['nomeProduto'] ?>">
 
                            <div class="position-absolute top-0 end-0 p-3 d-flex flex-column gap-2">
 
                                <a href="#" class="text-dark">
                                    <i class="bi bi-heart fs-4">
                                        <span class="material-symbols-outlined">
                                            favorite
                                        </span>
                                    </i>
                                </a>
 
                                <a href="#" class="text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         width="20"
                                         height="20"
                                         fill="currentColor"
                                         class="bi bi-share"
                                         viewBox="0 0 16 16">
                                        <path d="M13.5 1a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5"/>
                                    </svg>
                                </a>
 
                            </div>
 
                        </div>
                       
                        <div class="card-body">
                    
                            <h5 class="fw-bold">
                                <?= htmlspecialchars($produto['nomeProduto'], ENT_QUOTES, 'UTF-8') ?>
                            </h5>
 
                            <p class="text-secondary">
                                A partir de R$ 5.489
                            </p>
 
                            <span class="badge bg-success">
                                Até 10% OFF
                            </span>
 
                            <span class="badge bg-success-subtle text-success">
                                Até 5% Cashback
                            </span>

                        </div>
 
                    </div>
                </div>
  <?php } ?>  
                <!-- Os demais cards permanecem exatamente iguais -->
                <!-- Basta colar aqui os outros cards -->
 
            </div>
 
            <div class="text-center mt-5">
 
                <button class="btn-ver-produtos">
                    <span>Ver todos os produtos</span>
                    <span class="seta">→</span>
                </button>
 
            </div>
 
        </div>
 
    </div>
 
</div>
</main>
</body>
</html>