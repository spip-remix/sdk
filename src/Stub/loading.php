<?php

/**
 * Cherche une fonction surchargeable et en retourne le nom exact,
 * après avoir chargé le fichier la contenant si nécessaire.
 *
 * Charge un fichier (suivant les chemins connus) et retourne si elle existe
 * le nom de la fonction homonyme `$dir_$nom`, ou suffixé `$dir_$nom_dist`
 *
 * Peut être appelé plusieurs fois, donc optimisé.
 *
 * @api
 * @uses include_spip() Pour charger le fichier
 * @example
 *     ```php
 *     $envoyer_mail = charger_fonction('envoyer_mail', 'inc');
 *     $envoyer_mail($email, $sujet, $texte);
 *     ```
 *
 * @param string $nom Nom de la fonction (et du fichier)
 * @param string $dossier Nom du dossier conteneur
 * @param bool $continue true pour ne pas râler si la fonction n'est pas trouvée
 *
 * @return string Nom de la fonction, ou false.
 */
function charger_fonction(string $nom, string $dossier = 'exec', bool $continue = false): string {
    return '';
}

/**
 * Inclut un fichier PHP (en le cherchant dans les chemins).
 *
 * @api
 * @uses find_in_path()
 * @example
 *     ```php
 *     include_spip('inc/texte');
 *     ```
 *
 * @param string $f Nom du fichier (sans l'extension)
 * @param bool $include false ne fait que le chercher, sinon il est inclus
 *
 * @return string|null null si fichier introuvable, sinon chemin du fichier trouvé
 */
function include_spip(string $f, bool $include = true): ?string {
	return '';
}

/**
 * Recherche un fichier dans les chemins de SPIP (squelettes, plugins, core)
 *
 * Retournera le premier fichier trouvé (ayant la plus haute priorité donc),
 * suivant l'ordre des chemins connus de SPIP.
 *
 * @api
 * @see  charger_fonction()
 * @uses creer_chemin() Pour la liste des chemins.
 * @example
 *     ```
 *     $f = find_in_path('css/perso.css');
 *     $f = find_in_path('perso.css', 'css');
 *     ```
 *
 * @param string $file
 *     Fichier recherché
 * @param string $dirname
 *     Répertoire éventuel de recherche (est aussi extrait automatiquement de $file)
 * @param bool|string $include
 *     - false : ne fait rien de plus
 *     - true : inclut le fichier (include_once)
 *     - 'require' : idem, mais tue le script avec une erreur si le fichier n'est pas trouvé.
 * @return string|null
 *     - string : chemin du fichier trouvé
 *     - false : fichier introuvable
 **/
function find_in_path(string $file, string $dirname = '', bool|string $include = false): ?string {
    return ' ';
}

function include_fichiers_fonctions() {}
