<?php
include_once __DIR__ . '/../../includes/conexao.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
  $nomeLoja = $_POST['nomeLoja'];
  $logoLoja = $_FILES['logoLoja'];

  if(isset($_FILES["logoLoja"])){

        // Recebe a imagem enviada
        $imagem = $_FILES["logoLoja"];

        // Verifica se o arquivo é realmente uma imagem
        $dadosImagem = getimagesize($imagem["tmp_name"]);

        if($dadosImagem != false){

            // Obtém a extensão da imagem jpg / .png
            $extensao = pathinfo($imagem["name"], PATHINFO_EXTENSION);

            // Gera um nome único para a imagem
            $nomeImagem = uniqid() . "." . $extensao;

            // Caminho onde a imagem será salva
            $caminho = "../assets/IMG/" . $nomeImagem;

            // Move a imagem para a pasta
            move_uploaded_file($imagem["tmp_name"], $caminho);

        }else{

            die("O arquivo enviado não é uma imagem.");

        }
    }

  $sqlInsert = "INSERT INTO loja (nomeLoja, logoLoja) VALUES (?, ?)";

  if (!empty($nomeLoja)&& !empty($logoLoja)){

    $resultado = mysqli_prepare($conexao, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        echo "<script>
                alert('Loja já cadastrada!');
                window.location='inserirLoja.php';
              </script>";
    }

    mysqli_stmt_bind_param($resultado,"ss",$nomeLoja,$logoLoja);
  }

  if (mysqli_query($conexao, $sqlInsert)) {
        echo "<script>
                alert('Loja cadastrada com sucesso!');
                window.location='inserirLoja.php';
              </script>";
    } else {
        echo "Erro ao cadastrar Loja: " . mysqli_error($conexao) .
        "<br><br>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Loja</title>
</head>
<body>
    <h1>Registro de Loja</h1>
    <br>

    <form action="inserirLoja.php" method="post" enctype="multipart/form-data">
        <label for="nomeLoja">Nome da Loja:</label>
        <input type="text" name="nomeLoja" id="nomeLoja">
        <br>

        <label for="logoLoja">Logo da loja:</label>
        <input type="file" name="logoLoja" id="logoLoja">
        <br>

        <button type="submit">Cadastrar Loja</button>
    </form>
</body>
</html>