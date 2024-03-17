<?php

/**
 * Renvoie le `$_GET` ou le `$_POST` émis par l'utilisateur
 * ou pioché dans un tableau transmis
 *
 * @api
 *
 * @param string $var Clé souhaitée
 * @param array|null $c Tableau transmis (sinon cherche dans GET ou POST)
 *
 * @return mixed|null null si la clé n'a pas été trouvée
 */
function _request(string $var, ?array $c = null): mixed {
	return null;
}
