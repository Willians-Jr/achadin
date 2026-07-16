<?php

include_once __DIR__ . '/../../includes/conexao.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){

  if (isset($_POST['nomeUsuario']) && isset($_POST['loginUsuario']) && isset($_POST['senhaUsuario'])&& isset($_POST['telefoneUsuario'])) {
$nomeUsuario = $_POST['nomeUsuario'];
$loginUsuario = $_POST['loginUsuario'];
$telefoneUsuario = $_POST['telefoneUsuario'];
$senhaUsuario = $_POST['senhaUsuario'];
$senhacripto=password_hash($senhaUsuario, PASSWORD_DEFAULT);
$senhaForte = $_POST['senhaForte'];


if(isset($_FILES["imgUsuario"])){
  $imagem = $_FILES['imgUsuario'];
  
  $nomeImagem = $imagem['name'];

  $caminho = "../../assets/UPLOAD/".$nomeImagem;

  move_uploaded_file($imagem['tmp_name'],$caminho);
}

if ($_POST['senhaForte'] !== 'true') {
    echo "Erro: A senha não atende aos critérios de segurança.";
    exit;
}

 $sql = "INSERT INTO usuario (nomeUsuario, loginUsuario, telefoneUsuario, senhaUsuario, imgUsuario) VALUES (?, ?, ?, ?, ?)";

    if (!empty($nomeUsuario) && !empty($loginUsuario) && !empty($senhaUsuario) &&!empty($telefoneUsuario)) {
      // PREPARET STATEMENT
      //o sql possui apenas os espaços reservados (?)
      //os dados são enviados separadamente
      //isso impede SQL injection - usuario mal intencionado invadir o sistema
      $resultado = mysqli_prepare($conexao,$sql);
      // liga as variaveis aos espaços reservados
      mysqli_stmt_bind_param($resultado,"sssss",$nomeUsuario,$loginUsuario, $telefoneUsuario, $senhacripto,$nomeImagem);
      // executa a query
      if (mysqli_stmt_execute($resultado)){
        
        echo "Novo usuário adicionado com sucesso!";
        
      } else {
        echo "Erro ao adicionar usuário: " . mysqli_error($conexao);
      }
    } else {
      echo "Erro: Todos os campos são obrigatórios.";
}
  }
} else {
    echo "Acesso negado: Este arquivo deve ser chamado via formulário.";
}
if(isset($resultado)){
mysqli_stmt_close($resultado);
}

// fecha stmt
    
?>

