<?php
include_once __DIR__ . '/../../includes/conexao.php';

$idLoja = (int)$_POST['idLoja'];
$nomeLoja = $_POST['nomeLoja'];
$logoLoja = $_POST['logoAtual']; // mantém a imagem atual por padrão

// Verifica se foi enviada uma nova imagem
if (isset($_FILES['logoLoja']) && $_FILES['logoLoja']['error'] == 0) {

    $imagem = $_FILES['logoLoja'];

    // Verifica se é uma imagem
    if (getimagesize($imagem["tmp_name"])) {

        $extensao = strtolower(pathinfo($imagem["name"], PATHINFO_EXTENSION));

        $nomeImagem = uniqid() . "." . $extensao;

        $caminho = __DIR__ . "/../../assets/UPLOAD/" . $nomeImagem;

        if (move_uploaded_file($imagem["tmp_name"], $caminho)) {

            // (Opcional) Apaga a imagem antiga
            $arquivoAntigo = __DIR__ . "/../../assets/UPLOAD/" . $_POST['logoAtual'];

            if (file_exists($arquivoAntigo)) {
                unlink($arquivoAntigo);
            }

            $logoLoja = $nomeImagem;
        }
    }
}

$sql = "UPDATE loja
        SET nomeLoja = ?, logoLoja = ?
        WHERE idLoja = ?";

$stmt = mysqli_prepare($conexao, $sql);

mysqli_stmt_bind_param(
    $stmt,
    "ssi",
    $nomeLoja,
    $logoLoja,
    $idLoja
);

if (mysqli_stmt_execute($stmt)) {

    echo "<script>
            alert('Loja atualizada com sucesso!');
            window.location='gerenciarLoja.php';
          </script>";

} else {

    echo "Erro: " . mysqli_error($conexao);

}
?>