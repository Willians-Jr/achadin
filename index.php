<?php
session_start();
require_once __DIR__ . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
$pesquisa="";

if (isset($_GET['nomeProduto'])){
  $pesquisa=trim($_GET['nomeProduto']);
  
}
$sqlProduto = "SELECT * FROM produto WHERE nomeProduto LIKE  '%$pesquisa%' ORDER BY nomeProduto";

$resultadoProduto = mysqli_query($conexao,$sqlProduto);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
</head>
<body>
    <main>
   <?php require_once ROOT_PATH . '/includes/header.php'; ?>
<!-- HEADER -->
<header class="bannerIndex text-center text-light py-5">
    <div class="container">

        <h1 class="display-1 opacity-50">
            BANNER
        </h1>
    </div>
</header>
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
                        <?php
                            $sql = "SELECT idLoja, nomeLoja FROM loja ORDER BY nomeLoja";
                            $resultado = mysqli_query($conexao, $sql);

                            while($dados = mysqli_fetch_assoc($resultado)){
                                echo " {$dados['nomeLoja']}";
                            }
                        ?>
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
            <?php
                $sql = "SELECT idCategoria, nomeCategoria FROM categoria ORDER BY nomeCategoria";
                $resultado = mysqli_query($conexao, $sql);
        
                echo "<option value='' disabled selected>Categorias</option>";

                while($dados = mysqli_fetch_assoc($resultado)){
                    echo "<option value={$dados['idCategoria']}> 
                    {$dados['nomeCategoria']}</option>";
                }
            ?>
        </select>

    </div>

</div>

<!-- FIM FILTROS -->
<!-- PROTUTOS -->
<div class="container">

    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-4">

        <?php while($produto = mysqli_fetch_assoc($resultadoProduto)) { ?>

            <div class="col">
                <div class="card h-100">

                    <img src="<?= BASE_URL ?>assets/UPLOAD/<?= !empty($produto['fotoProduto']) ? htmlspecialchars($produto['fotoProduto']) : 'sem-imagem.png' ?>" class="card-img-top" alt="<?= htmlspecialchars($produto['nomeProduto']) ?>">

                    <div class="card-body">

                        <h6><?= htmlspecialchars($produto['nomeProduto']) ?></h6>

                        <!-- <h4 class="text-danger">
                            R$ < ?= number_format($produto['precoProduto'],2,',','.') ?>
                        </h4> -->

                    </div>

                </div>
            </div>

        <?php } ?>

    </div>

</div>

<!-- FIM PRODUTOS -->
</main>

<?php require_once ROOT_PATH . '/includes/footer.php'; ?>

</body>
</html>