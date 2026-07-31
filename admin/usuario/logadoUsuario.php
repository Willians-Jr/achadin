<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

$pesquisa="";

if (isset($_GET['nomeProduto'])){
  $pesquisa=trim($_GET['nomeProduto']);
  
}
$sqlProduto = "SELECT * FROM produto WHERE nomeProduto LIKE  '%$pesquisa%' ORDER BY nomeProduto";
$resultadoProduto = mysqli_query($conexao,$sqlProduto);

if (isset($_SESSION['idUsuario'])) {
    $idLogado = $_SESSION['idUsuario'];

    $sqlUsuario = "SELECT idUsuario, nomeUsuario FROM usuario WHERE idUsuario = ?";
    
    if ($stmt = mysqli_prepare($conexao, $sqlUsuario)) {
        
        mysqli_stmt_bind_param($stmt, "i", $idLogado);
        
        mysqli_stmt_execute($stmt);
        
        $resultadoUsuario = mysqli_stmt_get_result($stmt);
    }
} else {
    header("Location: loginUsuario.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meu Perfil - Top Achados</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
</head>
<body>
  
<?php require_once ROOT_PATH . '/includes/header.php'; ?>

<!-- -->
 
<!-- SEGUNDO -->
 
<div class="menuUsuario py-2">
    <div class="container d-flex flex-column flex-md-row justify-content-between align-items-md-center">
 
        <div class="textoUsuario mb-2 mb-md-0">
            Olá, <span class="nomeUsuario">
            <?php
            if ($usuario = mysqli_fetch_assoc($resultadoUsuario)) {
            echo $usuario['nomeUsuario'];
        }
            ?>
            </span>
        </div>
 
       <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center">
 
           <a href="#" class="nav-link linkUsuario d-flex align-items-center px-0">
    <span class="material-symbols-outlined me-1">
        person
    </span>
    Minha conta
</a>
 
<span class="mx-3 text-secondary d-none d-md-inline">|</span>
 
<a href="logoutUsuario.php" class="nav-link linkSair px-0 mt-2 mt-md-0 ms-md-3">
    Sair
</a>
 
        </div>
 
    </div>
</div>
</body>
</html>