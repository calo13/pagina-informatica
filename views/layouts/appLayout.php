<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8">
        <title>ADMIN IM</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta http-equiv="Expires" content="0">
        <meta http-equiv="Last-Modified" content="0">
        <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
        <meta http-equiv="Pragma" content="no-cache">

        <!-- Favicon -->
        <link href="/images/logo.png" rel="icon">


        <meta name="description" content="Página de la Industria MIlitar MDN.">
        <meta name="keywords" content="especies, estancadas, mindef, ministerio, defensa, guatemala, explosivos">
        <meta name="robots" content="index, follow">
        <link rel="canonical" href="https://industriamilitar.mindef.mil.gt/">

        <meta property="og:title" content="Industria MIlitar">
        <meta property="og:description" content="Pagina de la Industria MIlitar MINDEF.">
        <meta property="og:image" content="https://industriamilitar.mindef.mil.gt/images/logo.png">
        <meta property="og:url" content="https://industriamilitar.mindef.mil.gt">
        <meta property="og:type" content="website">
        <meta property="og:image:width" content="1200">
        <meta property="og:image:height" content="630">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Industria MIlitar MINDEF.">
        <meta name="twitter:description" content="Pagina de la Industria MIlitar MINDEF.">
        <meta name="twitter:image" content="https://industriamilitar.mindef.mil.gt/images/logo.png">
        <meta name="twitter:url" content="https://industriamilitar.mindef.mil.gt">

        <meta http-equiv="Content-Language" content="es">


        <meta name="author" content="Abner Daniel Fuentes Juárez">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&family=Red+Rose:wght@600;700&display=swap"
            rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">
        <link rel="stylesheet" href="<?= asset('build/css/styles.css') ?>">
        <!-- JavaScript Libraries -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/3f7d66e10f.js" crossorigin="anonymous"></script>
        <!-- Template Javascript -->
        <script defer src="<?= asset('./build/js/app.js') ?>"></script>
        <script defer src="<?= asset('./build/js/main.js') ?>"></script>

    </head>

    <body>
        <!-- Spinner Start -->
        <div id="spinner"
            class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;"></div>
        </div>
        <!-- Spinner End -->


        <!-- Topbar Start -->
        <nav class="navbar fixed navbar-expand-lg bg-primary px-2 d-flex justify-content-between  ">
            <div class="w-50">
                <button type="button" class="btn me-0" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasWithBothOptions" aria-controls="offcanvasWithBothOptions">
                    <i class="fas fa-bars text-white fa-2xl"></i>
                </button>
                <!-- <p class="h1 text-white">DGEEEI</p>  -->
                <a href="/admin/">
                    <img src="/images/logo.png" width="40px" alt="logo">
                    <span class="h2 align-middle text-white d-none d-md-inline">IM</span>
                </a>
            </div>
            <div class="dropdown-center">
                <button class="btn rounded text-white dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="true"><?= isset($_SESSION['username']) ? $_SESSION['username'] : 'USERNAME' ?><i
                        class="ms-2 bi bi-person-circle"></i></button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="/logout"><i class="bi bi-box-arrow-left me-2"></i>Salir</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- Topbar End -->

        <div class="offcanvas offcanvas-start" tabindex="1" id="offcanvasWithBothOptions"
            aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header">
                <p class="offcanvas-title h3" id="offcanvasWithBothOptionsLabel">Seleccione una opcion</p>
                <button type="button" class="btn-close text-white" data-bs-dismiss="offcanvas" data-backdrop="false"
                    aria-label="Close" data-bs-target="offcanvasWithBothOptions"></button>
            </div>
            <div class="offcanvas-body">
                <div class="accordion accordion-flush border w-100" id="accordionFlushExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                <i class="bi bi-receipt me-2"></i> Admin
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="list-group list-group-flush">
                                    <a href="/admin/productos" class="list-group-item list-group-item-action"><i
                                            class="fas fa-file-circle-plus me-2"></i>Productos</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <main class="container pt-2" style="min-height: 75vh;">
            <?= $contenido ?>
        </main>
        <!-- Copyright Start -->
        <div class="container-fluid copyright  py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-6 text-center text-md-start">
                        <p class="mb-0 text-center">&copy; Comando de Informática y Tecnología <?= date('Y') ?></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Copyright End -->

        <a href="#" class="btn btn-lg btn-danger btn-lg-square rounded-circle back-to-top d-flex align-items-center"><i
                class="fas fa-arrow-up"></i></a>

    </body>

</html>