<?php
declare(strict_types=1);
session_start();

// Si s'hi accedeix sense dades validades a la sessió, redirigir a registre.php
if (!isset($_SESSION['dades_validades']) || !is_array($_SESSION['dades_validades'])) {
    header('Location: registre.php');
    exit;
}

// Bolquem les dades a una variable i les eliminem immediatament de la sessió
$dades = $_SESSION['dades_validades'];
unset($_SESSION['dades_validades']);

require_once __DIR__ . '/includes/header.php';
?>

<div class="row justify-content-center mt-5">
    <div class="col-md-8 col-lg-6">
        <div class="card shadow-sm border-0 border-top border-success border-4">
            <div class="card-body p-4 p-md-5">
                
                <div class="text-center mb-4">
                    <span class="display-3">✅</span>
                    <h2 class="h3 mt-3">Registre completat correctament!</h2>
                    <p class="text-muted">Aquestes són les dades que han estat validadas i normalitzades pel servidor.</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <tbody>
                            <tr>
                                <th class="w-25 text-end bg-light">Nom:</th>
                                <td><?= htmlspecialchars((string) ($dades['nom'] ?? '')) ?></td>
                            </tr>
                            <tr>
                                <th class="text-end bg-light">Email:</th>
                                <td><?= htmlspecialchars((string) ($dades['email'] ?? '')) ?></td>
                            </tr>
                            <tr>
                                <th class="text-end bg-light">Edat:</th>
                                <td><?= htmlspecialchars((string) ($dades['edat'] ?? '')) ?> anys</td>
                            </tr>
                            <tr>
                                <th class="text-end bg-light">Telèfon:</th>
                                <td>
                                    <?php
                                    $tel = (string) ($dades['telefon'] ?? '');
                                    echo $tel === '' ? '<em class="text-muted">No indicat</em>' : htmlspecialchars($tel);
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <th class="text-end bg-light">Població:</th>
                                <td><?= htmlspecialchars((string) ($dades['poblacio'] ?? '')) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="text-center mt-4">
                    <a href="index.php" class="btn btn-primary fw-semibold px-4 py-2">Tornar a l'inici</a>
                </div>
                
            </div>
        </div>
    </div>
</div>

<?php
require_once __DIR__ . '/includes/footer.php';
?>