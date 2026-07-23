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
    <link rel="preconnect" href="https://fonts.googleapis.comht@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  </head>
  <?php require_once ROOT_PATH . '/includes/header.php'; ?>

  <body class="bg-light">
    <main>
 
<div class="container py-4">
 
    <div class="row shadow rounded-4 overflow-hidden bg-white">
 
        <!-- Lado esquerdo -->
        <div class="ladoEsquerdoAdmin col-md-4 text-center p-5 border-end ">
 
            <!-- LOGO -->
            <a class="navbar-brand logoA" href="index.html">
            <img src="../../assets/IMG/Catavento.png" class="imgLogo" alt="LOGO">
 
            <div class="logoTexto">
                <span class="logo">Top</span>
                <span class="logo">Achados</span>
            </div>
            </a>
 
            <h5 class="fw-bold text-white">"O que você busca está aqui!"</h5>
 
        </div>
 
        <!-- Lado direito -->
        <div class="col-md-8 p-5">
 
            <h1 class="text-center mb-5">
                Formulário de cadastro de Usuário
            </h1>
 
              <form action="inserirUsuario.php" method="post"  enctype="multipart/form-data">
 
               
        <input type="hidden" name="senhaForte" id="senhaForte" value="false">
           
 
                 <div class="mb-3">
                   <label class="form-label" for="nomeUsuario" >Nome:</label>
        <input class="form-control"   type="text"
           
            id="nomeUsuario"
            name="nomeUsuario"
            placeholder="Ex.: Francisco da Silva"
          />
                </div>
 
                 <div class="mb-3">
                   <label class="form-label" for="loginUsuario">Login:</label>
        <input class="form-control"   type="text"
           
            id="loginUsuario"
            name="loginUsuario"
            placeholder="Ex.: Usu@rio122"
          />
           
       
                </div>
 
                  <div class="mb-3">
                   <label class="form-label" for="telefoneUsuario">Telefone:</label>
        <input class="form-control"   type="text"
            id="tel"
            name="telefoneUsuario"
            data-mask="(00)00000-0000"
            placeholder="Ex.: (00)00000-0000"
          />
           
     
                </div>
 
                  <div class="mb-3">
                   <label class="form-label" for="senhaUsuario">Senha:</label>
        <input class="form-control" type="password"
            id="senhaUsuario"
            name="senhaUsuario"
            onkeyup="verificarSenha()"
            placeholder="Ex.: Senh@122"
          />
           
              <span id="erroSenha" ></span>
                </div>
   <div class="mb-3">
      <input class="form-check-input" type="checkbox" value="" id="checkDefault" onclick="mostrarSenha()">
      <label class="form-check-label"for="checkDefault">
        Mostrar senha
      </label>
  </div>
 
 
  <div class="mb-3">
    <label class="form-label">
      Foto do usuario:
    </label>
  <input class="form-control" type="file" name="imgUsuario"/>
 
 
</div>
 
 
 
 <div class="text-center">
            <button type="submit"  class="btn btn-primary rounded-pill px-5 py-2"
                        style="min-width:200px;">
              Cadastrar
            </button>
            <a href="perfilUsuario.php">Tabela</a>
            <a href="loginUsuario.php">Login</a>
          </div>
        </form>
      </div>

      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
      <script src="<?= BASE_URL ?>assets/JS/validacoes.js"></script>
      <script src="<?= BASE_URL ?>assets/JS/mascara.js"></script>

    </main>
  </body>  
</html>

<?php require_once ROOT_PATH . '/includes/footer.php';?>