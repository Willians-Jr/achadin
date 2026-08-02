<?php
require_once __DIR__ . '/includes/config.php';
?>


<!DOCTYPE html>
<html lang="pt-BR">
<?php $titulo="TopAchados - Como Funciona";
 require_once ROOT_PATH . '/includes/head.php'; ?>
<body>
  <main>
     <?php require_once ROOT_PATH . '/includes/header.php'; ?>
<div class="container py-5">
 
    <!-- menu -->
    
 
    <!-- Título -->
    <h2 class="fw-bold">Como Funciona</h2>
 
    <p class="text-secondary mb-5">
        Veja como é fácil economizar com o Top Achados.
    </p>
 
    <!-- Passos -->
    <div class="row g-4">
 
        <div class="col-md-6 col-lg-3">
            <div class="card cartao-passo h-100  rounded-4 shadow-sm position-relative">
 
                <span class="numeroPasso">1</span>
 
                <div class="card-body text-center p-4">
 
                    <i class="bi bi-search display-3 text-primary"></i>
 
                    <h6 class="fw-bold mt-3">
                        Encontre uma oferta
                    </h6>
 
                    <p class="small text-secondary mb-0">
                        Pesquise pela loja, categoria ou produto desejado e navegue pelas melhores ofertas disponíveis.
                    </p>
 
                </div>
 
            </div>
        </div>
 
        <div class="col-md-6 col-lg-3">
            <div class="card cartao-passo h-100  rounded-4 shadow-sm position-relative">
 
                <span class="numeroPasso">2</span>
 
                <div class="card-body text-center p-4">
 
                    <i class="bi bi-send-fill display-1 text-primary"></i>
 
                    <h6 class="fw-bold mt-3">
                        Acesse a loja
                    </h6>
 
                    <p class="small text-secondary mb-0">
                        Você será redirecionado para a loja parceira de forma segura.
                    </p>
 
                </div>
 
            </div>
        </div>
 
        <div class="col-md-6 col-lg-3">
            <div class="card cartao-passo h-100 rounded-4 shadow-sm position-relative">
 
                <span class="numeroPasso">3</span>
 
                <div class="card-body text-center p-4">
 
                    <i class="bi bi-cart3 display-1 text-primary"></i>
 
                    <h6 class="fw-bold mt-3">
                        Finalize sua compra
                    </h6>
 
                    <p class="small text-secondary mb-0">
                        Adicione os produtos ao carrinho e utilize o cupom, quando disponível.
                    </p>
 
                </div>
 
            </div>
        </div>
 
        <div class="col-md-6 col-lg-3">
            <div class="card cartao-passo h-100 rounded-4 shadow-sm position-relative">
 
                <span class="numeroPasso">4</span>
 
                <div class="card-body text-center p-4">
 
                    <i class="bi bi-coin display-3 text-primary"></i>
 
                    <h6 class="fw-bold mt-3">
                        Economize
                    </h6>
 
                    <p class="small text-secondary mb-0">
                        Receba descontos e cashback nas suas compras.
                    </p>
 
                </div>
 
            </div>
        </div>
 
    </div>
 
    <!-- Informações -->
 
    <div class="card caixa-informacoes rounded-4 shadow-sm mt-5">
 
        <div class="row g-0">
 
            <div class="col-lg-3 col-md-6 border-end">
                <div class="d-flex align-items-center p-4">
 
                    <i class="bi bi-lock-fill fs-1 text-primary me-3"></i>
 
                    <div>
                        <h6 class="fw-bold mb-1">Links verificados</h6>
                        <small class="text-secondary">
                            Todos os links são verificados.
                        </small>
                    </div>
 
                </div>
            </div>
 
            <div class="col-lg-3 col-md-6 border-end">
                <div class="d-flex align-items-center p-4">
 
                    <i class="bi bi-arrow-repeat fs-1 text-primary me-3"></i>
 
                    <div>
                        <h6 class="fw-bold mb-1">Ofertas atualizadas</h6>
                        <small class="text-secondary">
                            Novas ofertas todos os dias.
                        </small>
                    </div>
 
                </div>
            </div>
 
            <div class="col-lg-3 col-md-6 border-end">
                <div class="d-flex align-items-center p-4">
 
                    <i class="bi bi-gift fs-1 text-primary me-3"></i>
 
                    <div>
                        <h6 class="fw-bold mb-1">100% Gratuito</h6>
                        <small class="text-secondary">
                            Sempre gratuito para você.
                        </small>
                    </div>
 
                </div>
            </div>
 
            <div class="col-lg-3 col-md-6">
                <div class="d-flex align-items-center p-4">
 
                    <i class="bi bi-shield-check fs-1 text-success me-3"></i>
 
                    <div>
                        <h6 class="fw-bold mb-1">Compra segura</h6>
                        <small class="text-secondary">
                            Seus dados protegidos.
                        </small>
                    </div>
 
                </div>
            </div>
 
        </div>
 
    </div>
 
</div>
</main>
<?php require_once ROOT_PATH . '/includes/footer.php'; ?>
</body>
</html>