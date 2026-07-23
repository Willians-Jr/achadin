<?include_once __DIR__ . '/config.php';?>
<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Top Achados - Footer</title>


    <!-- Bootstrap CSS -->

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <!-- CSS do Footer -->

    <link rel="stylesheet"
          href="topAchados/Rodapé/style.css">

</head>


<body>


    <footer class="footer py-4">

        <div class="container">

            <div class="row align-items-start g-4">


                <!-- =====================================
                     TOP ACHADOS
                ====================================== -->

                <div class="col-12 col-md-6 col-lg-6">


                    <!-- LOGO -->

                    <a class="navbar-brand logoA d-flex align-items-center gap-2"
                       href="<?= BASE_URL?>index.php">


                        <img src="<?= BASE_URL ?>assets/IMG/Catavento.png"
                             class="imgLogo"
                             alt="Logo Top Achados">


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


                <!-- =====================================
                     FRONTEND
                ====================================== -->

                <div class="col-12 col-md-3 col-lg-3 footer-column">


                    <h3 class="h6 text-uppercase fw-bold mb-3">

                        FrontEnd

                    </h3>


                    <p class="mb-0">

                        Nomes dos responsáveis

                    </p>

                </div>


                <!-- =====================================
                     BACKEND
                ====================================== -->

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


</body>

