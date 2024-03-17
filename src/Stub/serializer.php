<?php

function ecrire_fichier_securise(
    $fichier,
    $contenu,
    $ecrire_quand_meme = false,
    $truncate = true
): bool {
    return true;
}

function lire_fichier_securise(
    $fichier,
    &$contenu,
    $options = []
) {
	if ($res = lire_fichier($fichier, $contenu, $options)) {
		$contenu = substr((string) $contenu, strlen('<?php die (\'Acces interdit\'); ?>' . "\n"));
	}

	return $res;
}
