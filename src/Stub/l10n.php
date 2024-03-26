<?php

function _T(string $texte = '', array $args = []): string { return $texte; }

/**
 * Afficher un message "un truc"/"N trucs"
 * Les items sont à indiquer comme pour la fonction _T() sous la forme :
 * "module:chaine"
 *
 * @param int $nb : le nombre
 * @param string $chaine_un : l'item de langue si $nb vaut un
 * @param string $chaine_plusieurs : l'item de lanque si $nb >= 2
 * @param string $var : La variable à remplacer par $nb dans l'item de langue (facultatif, défaut "nb")
 * @param array $vars : Les autres variables nécessaires aux chaines de langues (facultatif)
 * @return string : la chaine de langue finale en utilisant la fonction _T()
 */
function singulier_ou_pluriel(int $nb, string $chaine_un, string $chaine_plusieurs, string $var = 'nb', array $vars = []): string { return ''; }
