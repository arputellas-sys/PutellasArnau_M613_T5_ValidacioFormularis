<?php
declare(strict_types=1);
require_once __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center text-center mt-5">
    <div class="col-md-8">
        <h1 class="display-5 fw-bold mb-3">Benvingut/da al Sistema</h1>
        <p class="lead text-secondary mb-5">
            Aquesta aplicació et permet donar-te d'alta com a nou usuari de manera totalment segura. 
            Les teves dades estaran protegides mitjançant validacions de servidor avançades.
        </p>
        <a href="registre.php" class="btn btn-primary btn-lg shadow-sm px-5 py-3 rounded-pill fw-semibold">
            Anar al Registre d'Usuari &rarr;
        </a>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';