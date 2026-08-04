<?php
 require_once dirname(__DIR__, 2) . '/includes/config.php';

require_once ROOT_PATH . '/includes/conexao.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try{

    $nomeCategoria = trim($_POST['nomeCategoria']);

    if (empty($nomeCategoria)) {
        die("Informe o nome da categoria.");
    }

    $nomeCategoria = mysqli_real_escape_string($conexao, $nomeCategoria);

    $sqlInsert = "INSERT INTO categoria (nomeCategoria)
                  VALUES ('$nomeCategoria')";

    if (mysqli_query($conexao, $sqlInsert)) {
        $_SESSION['mensagem'] = "Categoria cadastrada com sucesso!!";
        $_SESSION['tipoMensagem'] = "success";
        header("Location: gerenciarCategoria.php");

    } else {

        throw new Exception(mysqli_error($conexao));

    }

}catch(Throwable $e){

    $_SESSION['mensagem'] = "Erro ao cadastrar a categoria. Erro: " . $e->getMessage();
    $_SESSION['tipoMensagem'] = "danger";
    header("Location: gerenciarCategoria.php");
    exit;
}

}

$sql = "SELECT idCategoria, nomeCategoria
        FROM categoria";

$resultado = mysqli_query($conexao, $sql);
?>