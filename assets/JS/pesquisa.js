/**
 * Atualiza o parâmetro "ordenar" na URL e recarrega a página com o
 * novo critério de ordenação, mantendo os demais filtros de pesquisa.
 */
function atualizarOrdenacao(valor) {
  const params = new URLSearchParams(window.location.search);
  params.set("ordenar", valor);
  window.location.search = params.toString();
}
