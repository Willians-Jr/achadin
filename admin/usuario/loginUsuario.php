<?php
session_start();
include_once __DIR__ . '/../../includes/conexao.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $loginUsuario = $_POST['loginUsuario'];
    $senhaUsuario = $_POST['senhaUsuario'];

    $sql = "SELECT * FROM usuario WHERE loginUsuario = '$loginUsuario'";

    $resultado = mysqli_query($conexao, $sql);

    if(mysqli_num_rows($resultado)>0){

      $dados = mysqli_fetch_assoc($resultado);

      if(password_verify($senhaUsuario, $dados['senhaUsuario'])){

      $_SESSION['idUsuario']= $dados['idUsuario'];
      $_SESSION['nomeUsuario']= $dados['nomeUsuario'];
      $_SESSION['loginUsuario']= $dados['loginUsuario'];

      header('location: /../../index.php');
      }else {
      echo "Usuário ou senha incorretos!";
      }
    }else {
      echo "Usuário ou senha incorretos!";
    }
  }
?>
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
            <script src="../../assets/JS/validacoes.js"></script>