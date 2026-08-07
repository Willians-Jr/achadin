<?php include_once __DIR__ . '/config.php'; ?>


    <footer class="footer py-4">

        <div class="container">

            <div class="row align-items-start g-4">


                <!-- =====================================TOP ACHADOS====================================== -->

                <div class="col-12 col-md-6 col-lg-6">


                    <!-- LOGO -->

                    <a class="navbar-brand logoA d-flex align-items-center gap-2"href="<?= BASE_URL?>">


                        <img src="<?= BASE_URL ?>assets/IMG/Catavento.png" class="imgLogo"alt="Logo Top Achados">


                        <div class="logoTexto">

                            <span class="logo">
                                Top
                            </span>

                            <span class="logo">
                                Achados
                            </span>

                        </div>

                    </a>


                    <!-- SLOGAN -->

                    <p class="footer-slogan mt-3 mb-0">

                        O que você busca está aqui!

                    </p>

                </div>


                <!-- =====================================FRONTEND ====================================== -->

                <div class="col-12 col-md-3 col-lg-3 footer-column">


                    <h3 class="h6 text-uppercase fw-bold mb-3">

                        FrontEnd

                    </h3>


                    <p class="mb-0">

                        Nomes dos responsáveis

                    </p>

                </div>


                <!-- =====================================BACKEND====================================== -->

                <div class="col-12 col-md-3 col-lg-3 footer-column">


                    <h3 class="h6 text-uppercase fw-bold mb-3">

                        BackEnd

                    </h3>


                    <p class="mb-0">

                        Nomes dos responsáveis

                    </p>

                </div>


            </div>

        </div>

    </footer>

    <!-- Modal genérico para ampliar qualquer imagem (ver assets/JS/imagem.js) -->
    <div class="modal fade" id="modalImagemAmpliada" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content bg-transparent border-0">
                <button type="button" class="btn-close btn-close-white ms-auto m-2"
                    data-bs-dismiss="modal" aria-label="Fechar"></button>
                <img id="imagemAmpliadaConteudo" src="" alt="" class="img-fluid rounded mx-auto d-block">
            </div>
        </div>
    </div>

    <!-- Modal genérico para recortar imagem antes do upload (ver assets/JS/editarimg.js) -->
    <div class="modal fade" id="modalRecortarImagem" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Recortar imagem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <div style="max-height: 60vh; overflow: hidden;">
                        <img id="imagemParaRecortar" src="" alt="Imagem para recortar" style="max-width: 100%;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnConfirmarRecorte" class="btn btn-primary">Aplicar recorte</button>
                </div>
            </div>
        </div>
    </div>


