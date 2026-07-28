function mostrarNomeArquivo() {
  const input = document.getElementById("imgUsuario");
  const nome = document.getElementById("nomeArquivo");

  if (input.files.length > 0) {
    nome.innerHTML = "📷 " + input.files[0].name;
  } else {
    nome.innerHTML = "Nenhum arquivo selecionado";
  }
}
