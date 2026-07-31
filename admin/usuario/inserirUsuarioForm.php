<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Usuários - Cadastro</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  </head>
  

  <body class="bg-light">
    <main> 
    <?php require_once ROOT_PATH . '/includes/header.php'; ?>


<div class="container py-4">

  <div class="row shadow rounded-4 overflow-hidden">
        <!-- Lado esquerdo -->
        <div class="ladoEsquerdoAdmin col-md-4 text-center p-5 border-end ">
            <!-- LOGO -->
            <a class="navbar-brand logoA" href="<?= BASE_URL ?>index.php">
            <img src="<?= BASE_URL ?>assets/IMG/Catavento.png" class="imgLogo" alt="LOGO">

            <div class="logoTexto">
                <span class="logo">Top</span>
                <span class="logo">Achados</span>
            </div>
            </a>

            <h5 class="fw-bold text-white">O que você busca está aqui!</h5>

        </div>

        <!-- Lado direito -->
        <div class="col-md-8 p-5">

            <h1 class="text-center mb-5">
                Cadastro de Usuário
            </h1>

              <form action="inserirUsuario.php" method="post"  enctype="multipart/form-data">

          <input type="hidden" name="senhaForte" id="senhaForte" value="false">

                <div class="mb-3">
                <label class="form-label" for="nomeUsuario" >Nome:</label>
          <input class="form-control"   type="text"
            id="nomeUsuario"
            name="nomeUsuario"
            placeholder="Ex.: Francisco da Silva"
            required
          />
                </div>

                  <div class="mb-3">
                  <label class="form-label" for="emailUsuario">E-mail:</label>
          <input class="form-control"   type="email"
            id="emailUsuario"
            name="emailUsuario"
            placeholder="Ex.: email@address.com"
            required
          />

                </div>

                  <div class="mb-3">
                  <label class="form-label" for="senhaUsuario">Senha:</label>
          <input class="form-control" type="password"
            id="senhaUsuario"
            name="senhaUsuario"
            onkeyup="verificarSenha()"
            placeholder="Ex.: Senh@122"
            required
          />
          
              <span id="erroSenha" ></span>
                </div>
          <div class="mb-3">
            <input class="form-check-input" type="checkbox" value="" id="checkDefault" onclick="mostrarSenha()">
            <label class="form-check-label"for="checkDefault">
              Mostrar senha
            </label>
          </div>


        <div class="mb-4">
          <label class="form-label fw-semibold">Foto do usuário</label>

          <div class="border rounded-4 p-4 text-center ">

              <i class="bi bi-person-circle fs-1 text-primary"></i>

              <p class="mt-2 mb-3 text-muted">
                  Escolha uma foto de perfil
              </p>

            <input
                type="file"
                id="imgUsuario"
                name="imgUsuario"
                class="d-none"
                accept="image/*"
                onchange="mostrarNomeArquivo()">

            <label for="imgUsuario" class="btn btn-outline-primary rounded-pill px-4">
                <i class="bi bi-upload"></i>
                Selecionar imagem
            </label>

            <div id="nomeArquivo" class="mt-3 small text-secondary">
                Nenhum arquivo selecionado
            </div>

        </div>


      </div>
    </div>

          <div class="text-center">
            <button type="submit"  class="btn btn-primary rounded-pill px-5 py-2"
                        style="min-width:200px;">
              Cadastrar Usuário
            </button>
            <!-- <a href="perfilUsuario.php">Tabela</a>
            <a href="loginUsuario.php">Login</a> -->
          </div>
          
        </form>
        </div>
        </div>
</div>

    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
      <script src="<?= BASE_URL ?>assets/JS/validacoes.js"></script>
      <script src="<?= BASE_URL ?>assets/JS/mascara.js"></script>
    <?php require_once ROOT_PATH . '/includes/footer.php';?>
  </body>  
</html>