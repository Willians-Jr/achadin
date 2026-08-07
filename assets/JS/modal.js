/**
 * Exibe um modal Bootstrap pelo ID assim que a página carrega.
 * Usado pelas telas administrativas para mostrar mensagens de
 * sucesso/erro/aviso vindas de $_SESSION['mensagem'] (ex.: depois de
 * cadastrar/editar/excluir um registro).
 */
function mostrarModalMensagem(idModal) {
  document.addEventListener("DOMContentLoaded", function () {
    const elementoModal = document.getElementById(idModal);
    if (elementoModal) {
      const modal = new bootstrap.Modal(elementoModal);
      modal.show();
    }
  });
}
