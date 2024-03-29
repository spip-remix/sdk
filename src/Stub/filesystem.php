<?php

function ecrire_fichier(
    string $fichier,
    string $contenu,
    bool $ignorer_echec = false,
    bool $truncate = true
): bool {
    return true;
}

function lire_fichier(
    string $fichier,
    string &$contenu,
    array $options = [],
): bool {
    return true;
}

/**
 * Supprimer un fichier de manière sympa (flock).
 *
 * @api
 *
 * @param string $fichier Chemin du fichier
 * @param bool $lock true pour utiliser un verrou
 *
 * @return bool
 *     - true si le fichier n'existe pas ou s'il a bien été supprimé
 *     - false si on n'arrive pas poser le verrou ou si la suppression échoue
 */
function supprimer_fichier(
    string $fichier,
    bool $lock = true
): bool {
    return true;
}

/**
 * Supprimer brutalement un fichier ou un dossier, s'il existe.
 *
 * @param string $filename Chemin du fichier
 */
function spip_unlink(string $filename): void {}

function sous_repertoire($base, $subdir = '', $nobase = false, $tantpis = false): string
{
    return '';
}