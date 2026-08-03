<?php
require_once dirname(__DIR__, 2) . '/includes/config.php';
require_once ROOT_PATH . '/includes/conexao.php';

?>


<!DOCTYPE html>
<html lang="pt-BR">
<?php
  $titulo = "TopAchados - Lojas";
require_once ROOT_PATH . '/includes/head.php';
?>

<body>
  <?php require_once ROOT_PATH . '/includes/header.php'; ?>

<!-- LOJAS PARCEIRAS -->
    <main class="py-5 bg-body-tertiary">
      <div class="container">
        <div class="text-center mb-5">
          <span class="badge bg-warning text-dark mb-2">
            Principais Parceiros
          </span>
 
          <h2 class="fw-bold">Economize nas melhores lojas</h2>
 
          <p class="text-secondary">
            Cupons e ofertas atualizadas diariamente.
          </p>
        </div>
 
        <div class="row g-4 justify-content-center">
          <div class="col-6 col-md-4 col-lg-2">
            <a
              href="#"
              class="card loja-card border-0 shadow-sm h-100 text-decoration-none"
            >
              <div class="card-body text-center">
                <img
                  src="https://www.bing.com/th/id/OIP.VijPxffOEymQUPV_6565sAHaEK?w=193&h=135&c=8&rs=1&qlt=90&o=6&pid=ImgAns&rm=2%22
                  class="img-fluid mb-3 logo-loja"
                  alt="Amazon"
                />
                <h6 class="fw-semibold text-dark">Amazon</h6>
                <small class="text-success fw-semibold"> Até 50% OFF </small>
              </div>
            </a>
          </div>
 
          <div class="col-6 col-md-4 col-lg-2">
            <a
              href="#"
              class="card loja-card border-0 shadow-sm h-100 text-decoration-none"
            >
              <div class="card-body text-center">
                <img
                  src="https://th.bing.com/th/id/OIP.fdgixIHagMuYsorII9flLQHaHa?w=182&h=182&c=7&r=0&o=7&pid=1.7&rm=3"
                  class="img-fluid mb-3 logo-loja"
                  alt="Magazine Luiza"
                />
                <h6 class="fw-semibold text-dark">Magalu</h6>
                <small class="text-success fw-semibold"> Até 60% OFF </small>
              </div>
            </a>
          </div>
 
          <div class="col-6 col-md-4 col-lg-2">
            <a
              href="#"
              class="card loja-card border-0 shadow-sm h-100 text-decoration-none"
            >
              <div class="card-body text-center">
                <img
                  src="https://www.bing.com/th/id/OIP.YoclUhSAXQS5J-4MU8iPZAHaHa?w=193&h=193&c=8&rs=1&qlt=90&o=6&pid=ImgAns&rm=2%22
                  class="img-fluid mb-3 logo-loja"
                  alt="Shopee"
                />
                <h6 class="fw-semibold text-dark">Shopee</h6>
                <small class="text-success fw-semibold"> Frete Grátis </small>
              </div>
            </a>
          </div>
 
          <div class="col-6 col-md-4 col-lg-2">
            <a
              href="#"
              class="card loja-card border-0 shadow-sm h-100 text-decoration-none"
            >
              <div class="card-body text-center">
                <img
                  src="https://www.bing.com/th/id/OIP.Z2__DpOxb60ppG1o181dGwHaHa?w=193&h=193&c=8&rs=1&qlt=90&o=6&pid=ImgAns&rm=2%22
                  class="img-fluid mb-3 logo-loja"
                  alt="Mercado Livre"
                />
                <h6 class="fw-semibold text-dark">Mercado Livre</h6>
                <small class="text-success fw-semibold"> Até 45% OFF </small>
              </div>
            </a>
          </div>
 
          <div class="col-6 col-md-4 col-lg-2">
            <a
              href="#"
              class="card loja-card border-0 shadow-sm h-100 text-decoration-none"
            >
              <div class="card-body text-center">
                <img
                  src="https://www.bing.com/th/id/OIP.tQHqYG-rvyAbXLcYO7tZHQHaE8?w=193&h=135&c=8&rs=1&qlt=90&o=6&pid=ImgAns&rm=2%22
                  class="img-fluid mb-3 logo-loja"
                  alt="Kabum"
                />
                <h6 class="fw-semibold text-dark">Kabum</h6>
                <small class="text-success fw-semibold"> Ofertas Gamer </small>
              </div>
            </a>
          </div>
 
          <div class="col-6 col-md-4 col-lg-2">
            <a
              href="#"
              class="card loja-card border-0 shadow-sm h-100 text-decoration-none"
            >
              <div class="card-body text-center">
                <img
                  src="https://th.bing.com/th/id/OIP.Rus8soirZ-rLa3um4D5-fwHaE8?w=270&h=180&c=7&r=0&o=7&pid=1.7&rm=3"
                  class="img-fluid mb-3 logo-loja"
                  alt="AliExpress"
                />
                <h6 class="fw-semibold text-dark">AliExpress</h6>
                <small class="text-success fw-semibold"> Até 70% OFF </small>
              </div>
            </a>
          </div>
        </div>
      </div>
    </main>
    <?php require_once ROOT_PATH . '/includes/footer.php'; ?>
    </body>
</html>