<?php
session_start();
 require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $loginUsuario = trim($_POST['loginUsuario'] ?? '');
    $senhaUsuario = $_POST['senhaUsuario'] ?? '';

    $sql = "SELECT * FROM usuario WHERE loginUsuario = '$loginUsuario'";

    $resultado = mysqli_query($conexao, $sql);

    if (!$resultado) {
    die(mysqli_error($conexao));
    }

    if(mysqli_num_rows($resultado)>0){
      $dados = mysqli_fetch_assoc($resultado);

    
      if(password_verify($senhaUsuario, $dados['senhaUsuario'])){

      $_SESSION['idUsuario']= $dados['idUsuario'];
      $_SESSION['nomeUsuario']= $dados['nomeUsuario'];
      $_SESSION['loginUsuario']= $dados['loginUsuario'];

      header("Location: " . BASE_URL . "index.php");
      exit;
      }else {
      echo "Usuário ou senha incorretos!";
      }
    }else {
      echo "Usuário ou senha incorretos!";
    }
  }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Achadin - Login</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
</head>
<body>
  <main>
    <?php require_once ROOT_PATH . '/includes/header.php'; ?>
  <form action="" method="post">
          <label for="loginUsuario">Usuario:</label>
          <input
            type="text"
            
            id="loginUsuario"
            name="loginUsuario"
            
          />
          <br /><br />
          <label for="senhaUsuario">Senha:</label>
          <input
            type="password"
            
            id="senhaUsuario"
            name="senhaUsuario"
            
          />
          <span id="erroSenha" ></span>
           <div >
              <input class="form-check-input" type="checkbox" value="" id="checkDefault" onclick="mostrarSenha()">
              <label class="form-check-label" for="checkDefault">
                Mostrar senha
              </label>
            </div>
            <button type="submit" value="login" >
              Login
            </button>
           <script src="<?= BASE_URL ?>assets/JS/validacoes.js"></script>
