<?php

 require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){

  if (isset($_POST['nomeUsuario']) && isset($_POST['loginUsuario']) && isset($_POST['senhaUsuario'])&& isset($_POST['telefoneUsuario'])) {
$nomeUsuario = $_POST['nomeUsuario'];
$loginUsuario = $_POST['loginUsuario'];
$telefoneUsuario = $_POST['telefoneUsuario'];
$senhaUsuario = $_POST['senhaUsuario'];
$senhacripto = password_hash($senhaUsuario, PASSWORD_DEFAULT);
$senhaForte = $_POST['senhaForte'];



if (isset($_FILES["imgUsuario"]) && $_FILES["imgUsuario"]["error"] == UPLOAD_ERR_OK) {

    $imagem = $_FILES["imgUsuario"];

    $tiposPermitidos = ['image/jpeg', 'image/png', 'image/webp'];
    
    if (!in_array($imagem['type'], $tiposPermitidos)) {
    die("Formato de imagem inválido.");
}

    // Obtém a extensão do arquivo (.jpg, .png, etc.)
    $extensao = pathinfo($imagem['name'], PATHINFO_EXTENSION);

    // Gera um nome único para evitar arquivos com o mesmo nome
    $nomeImagem = uniqid() . "." . $extensao;

    $caminho = ROOT_PATH . "/assets/UPLOAD/" . $nomeImagem;

    if (!move_uploaded_file($imagem['tmp_name'], $caminho)) {
        die("Erro ao enviar a imagem.");
    }

} else {
    $nomeImagem = "";
}
if ($senhaForte !== 'true') {
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
      mysqli_stmt_bind_param($resultado,"sssss",$nomeUsuario,$loginUsuario, $telefoneUsuario, $senhacripto, $nomeImagem);
      // executa a query
      if (mysqli_stmt_execute($resultado)){
        
        header("location: perfilUsuario.php");
        
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
if (
    empty($nomeUsuario) ||
    empty($loginUsuario) ||
    empty($senhaUsuario) ||
    empty($telefoneUsuario)
) {
    die("Todos os campos são obrigatórios.");
}
if(isset($resultado)){
mysqli_stmt_close($resultado);
mysqli_close($conexao);
}

// fecha stmt
    
?>

