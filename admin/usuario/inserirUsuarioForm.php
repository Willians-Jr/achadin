<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro de Usuário</title>
    
  </head>
  <body>
    <?include_once __DIR__ . '/../../includes/header.php';?>
    <main >
      <div >
        <h1 >Cadastro de Usuário</h1>

        <form action="inserirUsuario.php" method="post"  enctype="multipart/form-data">
          <input type="hidden" name="senhaForte" id="senhaForte" value="false">
          <label for="nomeUsuario" >Nome:</label>
          <input
            type="text"
            
            id="nomeUsuario"
            name="nomeUsuario"
            
          />
          <br /><br />
          <label for="loginUsuario">Login:</label>
          <input
            type="text"
           
            id="loginUsuario"
            name="loginUsuario"
            
          />
          <br /><br />
          <label for="telefoneUsuario">Telefone:</label>
          <input
            type="text"
            id="tel"
            name="telefoneUsuario"
          />
          <br /><br />
          <label for="senhaUsuario">Senha:</label>
          <input
            type="password"
            id="senhaUsuario"
            name="senhaUsuario"
            onkeyup="verificarSenha()"
          />
          <span id="erroSenha" ></span>
           <div >
  <input type="checkbox" value="" id="checkDefault" onclick="mostrarSenha()">
  <label for="checkDefault">
    Mostrar senha
  </label>
</div>

          <br /><br />
          <div >
          <label >Foto do usuario</label>
            <input type="file" name="imgUsuario"></div>
         
          <div>
            <button type="submit" value="Cadastrar" >
              Cadastrar
            </button>
            <a href="perfilUsuario.php">Tabela</a>
            <a href="loginUsuario.php">Login</a>
          </div>
        </form>
      </div>
    </main>
  </body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script src="../../assets/JS/validacoes.js"></script>
<script src="../../assets/JS/mascara.js"></script>
  
</html>
