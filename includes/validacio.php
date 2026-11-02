<?php
declare(strict_types=1);

/**
 * Validació del Nom.
 * Ha de tenir entre 2 i 50 caràcters i acceptar lletres, espais, apòstrofs i guions.
 */
function validarNom(string $nom): ?string
{
    if ($nom === '') {
        return "El nom és obligatori.";
    }
    // \p{L} vol dir "qualsevol lletra (amb accents inclosos)"
    // /u vol dir "tracta el text com a UTF-8"
    if (!preg_match("/^[\p{L}\s'-]{2,50}$/u", $nom)) {
        return "El nom ha de tenir entre 2 i 50 caràcters (només lletres, espais, guions o apòstrofs).";
    }
    return null;
}

/**
 * Validació de l'Email.
 */
function validarEmail(string $email): ?string
{
    if ($email === '') {
        return "L'email és obligatori.";
    }
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return "El format de l'email no és vàlid.";
    }
    return null;
}

/**
 * Validació de l'Edat (Enter entre 18 i 120).
 */
function validarEdat(string $edat): ?string
{
    if ($edat === '') {
        return "L'edat és obligatòria.";
    }
    $edatValida = filter_var($edat, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 18, 'max_range' => 120]
    ]);
    if ($edatValida === false) {
        return "L'edat ha de ser un nombre enter entre 18 i 120.";
    }
    return null;
}

/**
 * Validació del Telèfon (Opcional, 9 dígits).
 * Aquesta funció s'ha de cridar DESPRÉS d'haver tret els espais i guions.
 */
function validarTelefon(string $telefon): ?string
{
    if ($telefon === '') {
        return null; // És opcional, si està buit no hi ha error.
    }
    if (!preg_match("/^\d{9}$/", $telefon)) {
        return "El telèfon ha de tenir exactament 9 dígits.";
    }
    return null;
}

/**
 * Validació de la Població.
 * Mateixos requisits que el nom.
 */
function validarPoblacio(string $poblacio): ?string
{
    if ($poblacio === '') {
        return "La població és obligatòria.";
    }
    if (!preg_match("/^[\p{L}\s'-]{2,50}$/u", $poblacio)) {
        return "La població ha de tenir entre 2 i 50 caràcters (només lletres, espais, guions o apòstrofs).";
    }
    return null;
}

/* =========================================================================
   FUNCIONS DE NORMALITZACIÓ
   ========================================================================= */

/**
 * Treu els espais i guions d'un telèfon.
 */
function normalitzarTelefon(string $telefon): string
{
    return str_replace([' ', '-'], '', $telefon);
}

/**
 * Converteix la primera lletra a majúscula respectant els caràcters UTF-8 (accents).
 * Soluciona el problema de ucfirst() amb paraules com "àger" -> "Àger".
 */
function normalitzarPoblacio(string $poblacio): string
{
    if ($poblacio === '') {
        return '';
    }
    // Agafem la primera lletra i la fem majúscula amb mb_strtoupper
    $primeraLletra = mb_strtoupper(mb_substr($poblacio, 0, 1, 'UTF-8'), 'UTF-8');
    // Agafem la resta del text
    $resta = mb_substr($poblacio, 1, null, 'UTF-8');
    
    return $primeraLletra . $resta;
}