<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= $titulo ?? 'Top Achados' ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/IMG/Catavento.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    <!-- CSS Global -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/CSS/style.css">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>

    <!-- CSS específico da página (opcional) -->
    <?php if (isset($cssPagina)) : ?>
        <link rel="stylesheet" href="<?= BASE_URL . $cssPagina ?>">
    <?php endif; ?>

    <style>
        .link-produto-vitrine{
            text-decoration:none;
            color:inherit;
            display:block;
        }

        .link-produto-vitrine:hover h6{
            color:#0d6efd;
        }

        /* .card{
            border-radius:18px;
            overflow:hidden;
        } */

        .produto-img{
            width:100%;
            height:220px;
            object-fit:contain;
            padding:20px;
        }

        .card-body{
            display:flex;
            flex-direction:column;
        }
    </style>
</head>