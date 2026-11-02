<?php
declare(strict_types=1);
session_start();

// 1. Si la petició no és POST, redirigir a registre.php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: registre.php');
    exit;
}

// 2. Comprovar el token CSRF
$tokenEnviat = (string) ($_POST['csrf_token'] ?? '');
$tokenSessio = (string) ($_SESSION['csrf_token'] ?? '');

if ($tokenEnviat === '' || !hash_equals($tokenSessio, $tokenEnviat)) {
    http_response_code(403);
    exit('Error 403: Token CSRF no vàlid o caducat. Petició rebutjada.');
}

require_once __DIR__ . '/includes/validacio.php';

$errors = [];
$dadesOriginals = [];
$dadesValidades = [];

// ============================================================================
// 3. RECUPERAR, TRACTAR I VALIDAR CADA CAMP
// ============================================================================

// --- NOM ---
$nomRaw = $_POST['nom'] ?? '';
$nomStr = is_string($nomRaw) ? trim($nomRaw) : '';
$dadesOriginals['nom'] = $nomStr;

$errorNom = validarNom($nomStr);
if ($errorNom !== null) {
    $errors['nom'] = $errorNom;
} else {
    // Normalització: ja està fet el trim()
    $dadesValidades['nom'] = $nomStr;
}

// --- EMAIL ---
$emailRaw = $_POST['email'] ?? '';
$emailStr = is_string($emailRaw) ? trim($emailRaw) : '';
$dadesOriginals['email'] = $emailStr;

$errorEmail = validarEmail($emailStr);
if ($errorEmail !== null) {
    $errors['email'] = $errorEmail;
} else {
    // Normalització: Passar a minúscules
    $dadesValidades['email'] = mb_strtolower($emailStr, 'UTF-8');
}

// --- EDAT ---
$edatRaw = $_POST['edat'] ?? '';
$edatStr = is_string($edatRaw) ? trim($edatRaw) : '';
$dadesOriginals['edat'] = $edatStr;

$errorEdat = validarEdat($edatStr);
if ($errorEdat !== null) {
    $errors['edat'] = $errorEdat;
} else {
    // Normalització: Es desa com a int
    $dadesValidades['edat'] = (int) $edatStr;
}

// --- TELÈFON ---
$telefonRaw = $_POST['telefon'] ?? '';
$telefonStr = is_string($telefonRaw) ? trim($telefonRaw) : '';
$dadesOriginals['telefon'] = $telefonStr;

// Normalització: Treure espais i guions ABANS de validar
$telefonNet = normalitzarTelefon($telefonStr);
$errorTelefon = validarTelefon($telefonNet);

if ($errorTelefon !== null) {
    $errors['telefon'] = $errorTelefon;
} else {
    // Normalització: Es desen els 9 dígits nets o un string buit
    $dadesValidades['telefon'] = $telefonNet;
}

// --- POBLACIÓ ---
$poblacioRaw = $_POST['poblacio'] ?? '';
$poblacioStr = is_string($poblacioRaw) ? trim($poblacioRaw) : '';
$dadesOriginals['poblacio'] = $poblacioStr;

$errorPoblacio = validarPoblacio($poblacioStr);
if ($errorPoblacio !== null) {
    $errors['poblacio'] = $errorPoblacio;
} else {
    // Normalització: Primera lletra en majúscula
    $dadesValidades['poblacio'] = normalitzarPoblacio($poblacioStr);
}

// ============================================================================
// 4. GESTIÓ DEL RESULTAT I REDIRECCIONS
// ============================================================================

// Si hi ha algun error, desem errors i dades originals per repoblar el formulari
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    $_SESSION['dades'] = $dadesOriginals;
    header('Location: registre.php');
    exit;
}

// Si tot és correcte, desem només les dades validades i normalitzades
$_SESSION['dades_validades'] = $dadesValidades;
header('Location: resultat.php');
exit;