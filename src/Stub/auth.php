<?php

/**
 * Prédicat sur les scripts de ecrire qui n'authentifient pas par cookie
 * et beneficient d'une exception
 *
 * @param string $nom
 * @param bool $strict
 *
 * @return bool
 */
function autoriser_sans_cookie(string $nom, bool $strict = false)
{
    return true;
}

/**
 * Indique si on est dans l'espace privé ou pas
 */
function test_espace_prive(): bool
{
	return false;
}
