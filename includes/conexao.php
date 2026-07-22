<?php
//variaveis/dados para a conexão com o BD

$servidor = "localhost";
$usuario = "root";
$senha = "";
$banco = "achadin";

// Criando a conexão
$conexao = mysqli_connect($servidor, $usuario, $senha, $banco);


// Verificando a conexão
if (!$conexao) {
    die("Conexão falhou: " . mysqli_connect_error());
}else{
//    echo"Conexão bem sucedida";
}

?>
