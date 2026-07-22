<?php
session_start();
include_once __DIR__ . '/includes/conexao.php';

?>
<br>
<a href="admin/produto/inserirProduto.php">Cadastrar Produto</a>
<a href="admin/usuario/inserirUsuarioForm.php">Cadastrar Usuario</a>
<a href="admin/loja/inserirLojaForm.php">Cadastrar loja</a>
<a href="admin/categoria/inserirCategoria.php">Cadastrar Categoria</a>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Página Inicial</title>
</head>
<body>
  <!-- NAV -->
    <!-- Imagem da logo -->
      <img src="" alt="Logo da loja"> 
      <p>Top achados</p>
    <!-- fim imagem -->

    <!-- Colocar esse form dentro do NAV -->
      <form action="pesquisarProduto.php" method="GET">
        <input type="text" id="pesquisa" name="pesquisa" placeholder="Buscar por palavra-chave">
        <button type="submit">Pesquisar</button>
      </form>
    <!-- fim  form -->
    
    <a href="">Categorias</a>
    <a href="">Produtos</a>
    <a href="">Lojas</a>

    <button><a>Meus achadinhos</a></button>
  <!-- FIM NAV -->

<?php
if(mysqli_num_rows($resultadoLoja)>0){
while ($dados = mysqli_fetch_assoc($resultadoLoja)) { ?>
  <img src="../../assets/UPLOAD/<?php echo $dados['logoLoja']; ?>" alt="Logo da Loja" width="100" /></td>
<?php }}?>

<button>Todos os filtros</button>

<select name="precoProduto" id="precoProduto">
  <option value="" disabled selected>Preços</option>
</select>

<select name="modeloProduto" id="modeloProduto">
  <option value="" disabled selected>Modelos</option>
</select>

<select name="categoriaProduto" id="categoriaProduto">
  <option value="" disabled selected>Categorias</option>
</select>

<?php
if(mysqli_num_rows($resultadoProduto)>0){
while ($dados = mysqli_fetch_assoc($resultadoProduto)) { ?>
  <img src="../../assets/UPLOAD/<?php echo $dados['fotoProduto']; ?>" alt="Imagem do Produto" width="100" /></td>
<?php }}?>

<a href="">Eletrônicos</a>
<a href="">Informática</a>
<a href="">Celulares</a>
<a href="">Games</a>
<a href="">Eletrodomésticos</a>
<a href="">Casa e Decoração</a>
<a href="">Moda</a>
<a href="">Beleza e Saúde</a>
<a href="">Automotivo</a>
<a href="">Livros</a>
<a href="">Bebês</a>
<a href="">Pet Shop</a>
</body>
</html>