<?php

/**
 * Retourne le second paramètre lorsque
 * le premier est considere vide, sinon retourne le premier paramètre.
 *
 * En php `sinon($a, 'rien')` retourne `$a`, ou `'rien'` si `$a` est vide.
 *
 * @filtre
 * @see filtre_logique() pour la compilation du filtre dans un squelette
 * @link https://www.spip.net/4313
 * @note
 *     L'utilisation de `|sinon` en tant que filtre de squelette
 *     est directement compilé dans `public/references` par la fonction `filtre_logique()`
 *
 * @param mixed $texte Contenu de reference a tester
 * @param mixed $sinon Contenu a retourner si le contenu de reference est vide
 *
 * @return mixed Retourne $texte, sinon $sinon.
 **/
function sinon(mixed $texte, mixed $sinon = '') { return $texte; }
