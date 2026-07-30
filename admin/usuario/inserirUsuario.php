<?php

 require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){

  if (isset($_POST['nomeUsuario']) && isset($_POST['senhaUsuario'])&& isset($_POST['emailUsuario'])) {
$nomeUsuario = $_POST['nomeUsuario'];
$emailUsuario = $_POST['emailUsuario'];
$senhaUsuario = $_POST['senhaUsuario'];

$senhaForte = $_POST['senhaForte'];


if (
    strlen($senhaUsuario) < 6 ||
    !preg_match('/[A-Z]/', $senhaUsuario) ||
    !preg_match('/[a-z]/', $senhaUsuario) ||
    !preg_match('/[0-9]/', $senhaUsuario) ||
    !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $senhaUsuario)
) {
    die("Cadastre uma senha forte!");
}
$senhacripto = password_hash($senhaUsuario, PASSWORD_DEFAULT);

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
    
    header("Location: " . BASE_URL . "admin/usuario/inserirUsuarioForm.php");
    exit;
}

 $sql = "INSERT INTO usuario (nomeUsuario, emailUsuario, senhaUsuario, imgUsuario) VALUES (?, ?, ?, ?)";

    if (!empty($nomeUsuario)&& !empty($senhaUsuario) &&!empty($emailUsuario)) {
    
      $resultado = mysqli_prepare($conexao,$sql);
      // liga as variaveis aos espaços reservados
      mysqli_stmt_bind_param($resultado,"ssss",$nomeUsuario, $emailUsuario, $senhacripto, $nomeImagem);
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
    empty($senhaUsuario) ||
    empty($emailUsuario)
) {
    die("Todos os campos são obrigatórios.");
}
if(isset($resultado)){
mysqli_stmt_close($resultado);
mysqli_close($conexao);
}

// fecha stmt
    
?>

