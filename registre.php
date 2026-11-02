<?php
declare(strict_types=1);
session_start();

// 1. Generació del token CSRF si no existeix a la sessió
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// 2. Recuperem els errors i les dades de la sessió (si n'hi ha)
$errors = $_SESSION['errors'] ?? [];
$dades  = $_SESSION['dades'] ?? [];

// 3. Esborrem els errors i dades de la sessió perquè no tornin a sortir en recarregar la pàgina (F5)
unset($_SESSION['errors'], $_SESSION['dades']);

require_once __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center mb-5">
    <div class="col-lg-6 col-md-8">
        
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="h3 mb-0">Registre d'Usuari</h2>
            <a href="index.php" class="btn btn-outline-secondary btn-sm">&larr; Tornar a l'inici</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                
                <!-- El formulari s'envia a valida_registre.php exclusivament per POST -->
                <form action="valida_registre.php" method="POST" novalidate>
                    
                    <!-- TOKEN CSRF OCULT -->
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                    <!-- CAMP: NOM -->
                    <div class="mb-3">
                        <label for="nom" class="form-label fw-medium">Nom complet <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control <?= isset($errors['nom']) ? 'camp-error is-invalid' : '' ?>" 
                            id="nom" 
                            name="nom" 
                            value="<?= htmlspecialchars((string)($dades['nom'] ?? '')) ?>" 
                            required
                        >
                        <?php if (isset($errors['nom'])): ?>
                            <div class="invalid-feedback fw-medium"><?= htmlspecialchars($errors['nom']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- CAMP: EMAIL -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-medium">Correu electrònic <span class="text-danger">*</span></label>
                        <input 
                            type="email" 
                            class="form-control <?= isset($errors['email']) ? 'camp-error is-invalid' : '' ?>" 
                            id="email" 
                            name="email" 
                            value="<?= htmlspecialchars((string)($dades['email'] ?? '')) ?>" 
                            required
                        >
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback fw-medium"><?= htmlspecialchars($errors['email']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- CAMP: EDAT -->
                    <div class="mb-3">
                        <label for="edat" class="form-label fw-medium">Edat <span class="text-danger">*</span></label>
                        <input 
                            type="number" 
                            class="form-control <?= isset($errors['edat']) ? 'camp-error is-invalid' : '' ?>" 
                            id="edat" 
                            name="edat" 
                            value="<?= htmlspecialchars((string)($dades['edat'] ?? '')) ?>" 
                            min="18" max="120"
                            required
                        >
                        <?php if (isset($errors['edat'])): ?>
                            <div class="invalid-feedback fw-medium"><?= htmlspecialchars($errors['edat']) ?></div>
                        <?php endif; ?>
                    </div>

                    <!-- CAMP: TELÈFON -->
                    <div class="mb-3">
                        <label for="telefon" class="form-label fw-medium">Telèfon <span class="text-muted fw-normal">(Opcional)</span></label>
                        <input 
                            type="text" 
                            class="form-control <?= isset($errors['telefon']) ? 'camp-error is-invalid' : '' ?>" 
                            id="telefon" 
                            name="telefon" 
                            value="<?= htmlspecialchars((string)($dades['telefon'] ?? '')) ?>"
                        >
                        <?php if (isset($errors['telefon'])): ?>
                            <div class="invalid-feedback fw-medium"><?= htmlspecialchars($errors['telefon']) ?></div>
                        <?php endif; ?>
                        <div class="form-text">Ha de tenir 9 dígits (s'accepten espais i guions).</div>
                    </div>

                    <!-- CAMP: POBLACIÓ -->
                    <div class="mb-4">
                        <label for="poblacio" class="form-label fw-medium">Població <span class="text-danger">*</span></label>
                        <input 
                            type="text" 
                            class="form-control <?= isset($errors['poblacio']) ? 'camp-error is-invalid' : '' ?>" 
                            id="poblacio" 
                            name="poblacio" 
                            value="<?= htmlspecialchars((string)($dades['poblacio'] ?? '')) ?>" 
                            required
                        >
                        <?php if (isset($errors['poblacio'])): ?>
                            <div class="invalid-feedback fw-medium"><?= htmlspecialchars($errors['poblacio']) ?></div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Registrar-se</button>
                </form>

            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>