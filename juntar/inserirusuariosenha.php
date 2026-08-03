<?php
 
include_once "../conexao.php";
 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    $nome = $_POST['nomeUsuario'];
    $login = $_POST['loginUsuario'];
    $senha = $_POST['senhaUsuario'];
    $senhaForte= $_POST['senhaForte'];
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
 
 
if (
    strlen($senha) < 6 ||
    !preg_match('/[A-Z]/', $senha) ||
    !preg_match('/[a-z]/', $senha) ||
    !preg_match('/[0-9]/', $senha) ||
    !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $senha)
) {
    die("Cadastre uma senha forte!");
}
 
 if(isset($_FILES["imgUsuario"])){
 
        // Recebe a imagem enviada
        $imagem = $_FILES["imgUsuario"];
 
        // Verifica se o arquivo é realmente uma imagem
        $dadosImagem = getimagesize($imagem["tmp_name"]);
 
        if($dadosImagem != false){
 
            // Obtém a extensão da imagem jpg / .png
            $extensao = pathinfo($imagem["name"], PATHINFO_EXTENSION);
 
            // Gera um nome único para a imagem
            $nomeImagem = uniqid() . "." . $extensao;
 
            // Caminho onde a imagem será salva
            $caminho = "imagens/" . $nomeImagem;
 
            // Move a imagem para a pasta
            move_uploaded_file($imagem["tmp_name"], $caminho);
 
        }else{
 
            die("O arquivo enviado não é uma imagem.");
 
        }
 
    }else{
 
        die("Selecione uma imagem.");
 
    }
    $sql = "INSERT INTO idusuario
            (nome_usuario, login_usuario, senha_usuario, img_usuario)
            VALUES (?, ?, ?, ?)";
 
    $resultado = mysqli_prepare($conexao, $sql);
 
    mysqli_stmt_bind_param(
        $resultado,
        "ssss",
        $nome,
        $login,
        $senhaHash,
        $nomeImagem
    );
 
 
 
 
 
    if (mysqli_stmt_execute($resultado)) {
       
        header("Location: ../index2.php");
exit;
    } else {
        echo "Não foi possível realizar o cadastro: " . mysqli_error($conexao);
    }
 
    mysqli_stmt_close($resultado);
}
 
?>
<!DOCTYPE html>
 
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <title>Cadastro de usuario</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="../style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
 
</head>
<body class="bg-light">
 
    <div class="container vh-100 d-flex justify-content-center align-items-center">
 
        <div class="card shadow-lg border-0" style="width: 400px;">
            <div class="card-body p-4">
  <form action="" method="post" enctype="multipart/form-data" id="formCadastro">
    <input type="hidden" id="senhaForte" name="senhaForte" value="false">
   
    <h2 class="text-center text-warning mb-4">Cadastro de Usuários</h2>
    <div class="mb-3">
<label class="form-label" for="nomeUsuario">Nome</label>
<input class="form-control" type="text" id="nomeUsuario" name="nomeUsuario">
</div>
 <div class="mb-3">
<label class="form-label" for="loginUsuario">Login</label>
<input class="form-control" type="text" id="loginUsuario" name="loginUsuario">
 
</div>
 
 <div class="mb-3">
<label class="form-label" for="senhaUsuario">Senha</label>
<input
    class="form-control"
    type="password"
    id="senhaUsuario"
    name="senhaUsuario"
    onfocus="mostrarRequisitos()"
    onkeyup="verificarSenha()">
<div id="requisitosSenha" class="mt-2" style="display: none;">
    <p id="reqTamanho" style="color:red;">❌ A senha precisa ter pelo menos 6 caracteres</p>
    <p id="reqMaiuscula" style="color:red;">❌ Deve conter uma letra maiúscula</p>
    <p id="reqMinuscula" style="color:red;">❌ Deve conter uma letra minúscula</p>
    <p id="reqNumero" style="color:red;">❌ Deve conter um número</p>
    <p id="reqEspecial" style="color:red;">❌ Deve conter um caractere especial</p>
</div>
 
</div>
 
 <div class="mb-3">
    <label class="form-label" for="fotoUsuario">Foto do Usuário</label>
<input class="form-control" type="file" id="imgUsuario" name="imgUsuario">
</div>
 
 
 
 
 <div class="mb-3">
<button class="btn btn-success" type="submit">Salvar</button>
 
 
</div>
 
 
</form>
 
</div></div></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
    <script src="script.js"></script>
 
 
  </body>
</html>