<?php

/**
 * Créer une table,
 * ou ajouter les champs manquants si elle existe déjà
 *
 * @param string $table
 * @param array $desc
 * @param bool|string $autoinc
 *   'auto' pour detecter automatiquement si le champ doit etre autoinc ou non
 *   en fonction de la table
 * @param bool $upgrade
 * @param string $serveur
 *
 * @return void
 */
function creer_ou_upgrader_table(
    string $table,
    array $desc,
    string|bool $autoinc,
    bool $upgrade = false,
    string $serveur = ''
): void {
}

/**
 * Supprime une table SQL (structure et données)
 *
 * @api
 * @see sql_create()
 * @see sql_drop_view()
 *
 * @param string $table Nom de la table
 * @param bool $exist true pour ajouter un test sur l'existence de la table, false sinon
 * @param string $serveur Nom du connecteur
 * @param bool|string $option
 *
 *     Peut avoir 3 valeurs :
 *
 *     - false : ne pas l'exécuter mais la retourner,
 *     - true : exécuter la requête
 *     - 'continue' : ne pas échouer en cas de serveur sql indisponible
 *
 * @return bool|string
 *
 *     - true en cas de succès,
 *     - texte de la requête si demandé,
 *     - false en cas d'erreur.
 */
function sql_drop_table(
    string $table,
    bool $exist = false,
    string $serveur = '',
    string|bool $option = true): bool|string {
	return true;
}
