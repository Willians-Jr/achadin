<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cadastro de Usuário</title>
  

    
   
  </head>
  <body>
    
    <main class="container d-flex justify-content-center align-items-center min-vh-100">
      <div class="card shadow p-4" style="width: 400px">
        <h1 class="text-center mb-4">Cadastro de Usuário</h1>

        <form action="inserirUsuario.php" method="post" class="mb-3" enctype="multipart/form-data">
          <input type="hidden" name="senhaForte" id="senhaForte" value="false">
          <label for="nomeUsuario" class="form-label">Nome:</label>
          <input
            type="text"
            class="form-control"
            id="nomeUsuario"
            name="nomeUsuario"
            
          />
          <br /><br />
          <label for="loginUsuario">Login:</label>
          <input
            type="text"
            class="form-control"
            id="loginUsuario"
            name="loginUsuario"
            
          />
          <br /><br />
          <label for="loginUsuario">Telefone:</label>
          <input
            type="text"
            class="form-control"
            id="telefoneUsuario"
            name="telefoneUsuario"
            
          />
          <br /><br />
          <label for="senhaUsuario">Senha:</label>
          <input
            type="password"
            class="form-control"
            id="senhaUsuario"
            name="senhaUsuario"
            onkeyup="verificarSenha()"
          />
          <span id="erroSenha" class="erro"></span>
           <div class="form-check">
  <input class="form-check-input" type="checkbox" value="" id="checkDefault" onclick="mostrarSenha()">
  <label class="form-check-label" for="checkDefault">
    Mostrar senha
  </label>
</div>

          <br /><br />
          <div class="mb-3">
          <label class="form-label">Foto do usuario</label>
            <input type="file" class="form-control" name="imgUsuario"></div>
         
          <div class="d-flex justify-content-center mt-4">
            <button type="submit" value="Cadastrar" class="btn btn-primary">
              Cadastrar
            </button>
          </div>
        </form>
      </div>
    </main>
  </body>

<script src="../../assets/JS/validacoes.js"></script>
  
</html>
