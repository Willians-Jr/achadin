<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';
exigirLogin();
exigirAdmin();

// Recebe e sanitiza os dados básicos
$idLoja    = isset($_POST['idLoja']) ? (int)$_POST['idLoja'] : 0;
$nomeLoja  = $_POST['nomeLoja'] ?? '';
$linkLoja  = $_POST['linkLoja'] ?? '';
$logoLoja  = $_POST['logoAtual'] ?? ''; // Mantém a imagem atual por padrão

// Verifica se foi enviada uma nova imagem sem erros
if (isset($_FILES['logoLoja']) && $_FILES['logoLoja']['error'] === UPLOAD_ERR_OK) {

    $imagem = $_FILES['logoLoja'];

    // Valida se o arquivo é realmente uma imagem
    $checarImagem = getimagesize($imagem["tmp_name"]);
    if ($checarImagem !== false) {

        $extensao = strtolower(pathinfo($imagem["name"], PATHINFO_EXTENSION));
        $nomeImagem = uniqid('loja_', true) . "." . $extensao;

        // Caminho FÍSICO no servidor usando ROOT_PATH
        $diretorioUpload = ROOT_PATH . "/assets/UPLOAD/";
        $caminhoFinal   = $diretorioUpload . $nomeImagem;

        if (move_uploaded_file($imagem["tmp_name"], $caminhoFinal)) {

            // Apaga a imagem antiga apenas se ela existir e for diferente da padrão
            if (!empty($_POST['logoAtual'])) {
                $arquivoAntigo = $diretorioUpload . $_POST['logoAtual'];
                if (file_exists($arquivoAntigo) && is_file($arquivoAntigo)) {
                    unlink($arquivoAntigo);
                }
            }

            // Atualiza a variável com o novo nome para salvar no banco
            $logoLoja = $nomeImagem;
        }
    }
}

// Prepara e executa a Query
$sql = "UPDATE loja SET nomeLoja = ?, logoLoja = ?, linkLoja = ? WHERE idLoja = ?";
$stmt = mysqli_prepare($conexao, $sql);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, "sssi", $nomeLoja, $logoLoja, $linkLoja, $idLoja);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Loja atualizada com sucesso!');
                window.location='gerenciarLoja.php';
              </script>";
    } else {
        echo "Erro ao executar a atualização: " . mysqli_stmt_error($stmt);
    }
    
    mysqli_stmt_close($stmt);
} else {
    echo "Erro na preparação da consulta: " . mysqli_error($conexao);
}
?>