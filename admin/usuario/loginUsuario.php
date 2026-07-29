<?php
session_start();
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $loginUsuario = trim($_POST['loginUsuario'] ?? '');
    $senhaUsuario = $_POST['senhaUsuario'] ?? '';

    // CORRIGIDO: Uso de Prepared Statement contra SQL Injection
    $sql = "SELECT * FROM usuario WHERE loginUsuario = ?";
    $stmt = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($stmt, "s", $loginUsuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

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
        } else {
            echo "Usuário ou senha incorretos!";
        }
    } else {
        echo "Usuário ou senha incorretos!";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Achadin - Login</title>
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
</head>
<body>
  <main>
    <?php require_once ROOT_PATH . '/includes/header.php'; ?>
       <!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Top Achados</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css"
      rel="stylesheet"
    />

    
    <link rel="stylesheet" href="cadastrarUsuario.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" rel="stylesheet">
  </head>

  <body>

    <?php require_once ROOT_PATH . '/includes/header.php'; ?>

    <div class="container py-5">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

          <h1 class="text-center mb-5">
            Login de Usuário
          </h1>

          <form action="loginUsuario.php" method="post" enctype="multipart/form-data">

            <div class="mb-3">
              <label class="form-label" for="loginUsuario">Login:</label>
              <input
                class="form-control"
                type="text"
                id="loginUsuario"
                name="loginUsuario"
              />
            </div>

            <div class="mb-3">
              <label class="form-label" for="senhaUsuario">Senha:</label>
              <input
                class="form-control"
                type="password"
                id="senhaUsuario"
                name="senhaUsuario"
                onkeyup="verificarSenha()"
              />

              <span id="erroSenha"></span>
            </div>

            <!-- Link de cadastro -->
            <div class="text-center mb-4">
              <span class="text-secondary">Não tem cadastro?</span>
              <a href="<?= BASE_URL ?>admin/usuario/inserirUsuarioForm.php"
                 class="text-decoration-none fw-semibold">
                Cadastre-se
              </a>
            </div>

            <div class="text-center">
              <button
                type="submit"
                class="btn btn-primary rounded-pill px-5 py-2"
                style="min-width:200px;">
                Fazer login
              </button>
            </div>

          </form>

        </div>
      </div>
    </div>

  </body>
</html>
  <!-- <form action="" method="post">
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
            </button> -->
           
           <script src="<?= BASE_URL ?>assets/JS/InserirFoto.js"></script>
