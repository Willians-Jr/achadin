<?php
 require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nomeLoja = trim($_POST['nomeLoja']);

    // Verifica se foi enviada uma imagem
    if (isset($_FILES["logoLoja"]) && $_FILES["logoLoja"]["error"] == 0) {

        $imagem = $_FILES["logoLoja"];

        // Verifica se é uma imagem
        $dadosImagem = getimagesize($imagem["tmp_name"]);

        if ($dadosImagem != false) {

            // Obtém a extensão
            $extensao = strtolower(pathinfo($imagem["name"], PATHINFO_EXTENSION));

            // Gera um nome único
            $nomeImagem = uniqid() . "." . $extensao;

            // Caminho da imagem
            $caminho = "../../assets/UPLOAD/" . $nomeImagem;

            // Move a imagem
            if (!move_uploaded_file($imagem["tmp_name"], $caminho)) {
                die("Erro ao salvar a imagem.");
            }

            // Nome que será salvo no banco
            $logoLoja = $nomeImagem;

        } else {
            die("O arquivo enviado não é uma imagem.");
        }

    } else {
        die("Selecione uma imagem.");
    }

    // Verifica se a loja já existe
    $sql = "SELECT * FROM loja WHERE nomeLoja = ?";

    $consulta = mysqli_prepare($conexao, $sql);
    mysqli_stmt_bind_param($consulta, "s", $nomeLoja);
    mysqli_stmt_execute($consulta);

    $resultado = mysqli_stmt_get_result($consulta);

    if (mysqli_num_rows($resultado) > 0) {

        echo "<script>
                alert('Loja já cadastrada!');
                window.location='inserirLoja.php';
              </script>";
        exit;
    }

    // Insere a loja
    $sqlInsert = "INSERT INTO loja (nomeLoja, logoLoja) VALUES (?, ?)";

    $stmt = mysqli_prepare($conexao, $sqlInsert);

    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $nomeLoja,
        $logoLoja
    );

    if (mysqli_stmt_execute($stmt)) {

        echo "<script>
                alert('Loja cadastrada com sucesso!');
                window.location='inserirLoja.php';
              </script>";

    } else {

        echo "Erro ao cadastrar loja: " . mysqli_error($conexao);

    }

    mysqli_stmt_close($consulta);
    mysqli_stmt_close($stmt);
    mysqli_close($conexao);
}
?>