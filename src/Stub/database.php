<?php

/**
 * Exécute une requête sur le serveur SQL.
 *
 * @note Ne génère pas d’erreur fatale si la connexion à la BDD n’existe pas
 * @deprecated 3.1 Pour compatibilité.
 * @see sql_query() ou l'API `sql_*`.
 *
 * @param string $query texte de la requête
 * @param string $serveur Nom du connecteur pour la base de données
 *
 * @return mixed
 */
function spip_query(string $query, string $serveur = ''): mixed
{
	return '';
}

/**
 * Retourne un enregistrement d'une selection
 *
 * Retourne un resultat d'une ressource obtenue avec sql_select()
 *
 * @api
 * @param mixed $res Ressource retournee par sql_select()
 * @param string $serveur Le nom du connecteur
 * @param bool|string $option
 *    Peut avoir 2 valeurs :
 *    - true -> executer la requete
 *    - continue -> ne pas echouer en cas de serveur sql indisponible
 *
 * @return array|null
 *    Tableau de cles (colonnes SQL ou alias) / valeurs (valeurs dans la colonne de la table ou calculee)
 *    presentant une ligne de resultat d'une selection
 */
function sql_fetch(mixed $res, string $serveur = '', string|bool $option = true): ?array {
	return [];
}

/**
 * Libère une ressource de résultat.
 *
 * Indique au gestionnaire SQL de libérer de sa mémoire la ressoucre de
 * résultat indiquée car on n'a plus besoin de l'utiliser.
 *
 * @param Object $res Ressource de résultat
 * @param string $serveur Nom de la connexion
 * @param bool|string $option
 *     Peut avoir 2 valeurs :
 *
 *     - true -> exécuter la requete
 *     - continue -> ne pas échouer en cas de serveur SQL indisponible
 *
 * @return bool True si réussi
 */
function sql_free(object $res, string $serveur = '', string|bool $option = true): true {
	return true;
}

/**
 * Supprime des enregistrements d'une table
 *
 * @example
 *     ```
 *     sql_delete('spip_articles', 'id_article='.sql_quote($id_article));
 *     ```
 *
 * @api
 *
 * @param string $table Nom de la table SQL
 * @param string|array $where Conditions à vérifier
 * @param string $serveur Nom du connecteur
 * @param bool|string $option
 *     Peut avoir 3 valeurs :
 *
 *     - false : ne pas l'exécuter mais la retourner,
 *     - true : exécuter la requête
 *     - 'continue' : ne pas échouer en cas de serveur sql indisponible
 *
 * @return bool|string
 *     - int : nombre de suppressions réalisées,
 *     - texte de la requête si demandé,
 *     - false en cas d'erreur.
 */
function sql_delete(string $table, string $where = '', string $serveur = '', string|bool $option = true): int|string {
	return 1;
}

/**
 * Effectue une requête de selection
 *
 * Fonction de selection (SELECT), retournant la ressource interrogeable par sql_fetch.
 *
 * @api
 * @see sql_fetch()      Pour boucler sur les resultats de cette fonction
 *
 * @param array|string $select Liste des champs a recuperer (Select)
 * @param array|string $from Tables a consulter (From)
 * @param array|string $where Conditions a remplir (Where)
 * @param array|string $groupby critere de regroupement (Group by)
 * @param array|string $orderby Tableau de classement (Order By)
 * @param string $limit critere de limite (Limit)
 * @param string|array $having Tableau ou chaine des des post-conditions à remplir (Having)
 * @param string $serveur Le serveur sollicite (pour retrouver la connexion)
 * @param bool|string $option Peut avoir 3 valeurs :
 *
 *     - false -> ne pas l'exécuter mais la retourner,
 *     - continue -> ne pas echouer en cas de serveur sql indisponible,
 *     - true|array -> executer la requête.
 *     Le cas array est, pour une requete produite par le compilateur,
 *     un tableau donnnant le contexte afin d'indiquer le lieu de l'erreur au besoin
 *
 *
 * @return mixed Ressource SQL
 *
 *     - Ressource SQL pour sql_fetch, si la requete est correcte
 *     - false en cas d'erreur
 *     - Chaine contenant la requete avec $option=false
 *
 * Retourne false en cas d'erreur, apres l'avoir denoncee.
 * Les portages doivent retourner la requete elle-meme en cas d'erreur,
 * afin de disposer du texte brut.
 *
 */
function sql_select(
	array|string $select = [],
	array|string $from = [],
	array|string $where = [],
	array|string $groupby = [],
	array|string $orderby = [],
	string $limit = '',
	array|string $having = [],
	string $serveur = '',
	string|bool $option = true
): ?object {
	return null;
}

/**
 * Echapper du contenu
 *
 * Echappe du contenu selon ce qu'attend le type de serveur SQL
 * et en fonction du type de contenu.
 *
 * Permet entre autres de se protéger d'injections SQL.
 *
 * Cette fonction est automatiquement appelée par les fonctions `sql_*q`
 * tel que `sql_instertq` ou `sql_updateq`
 *
 * @api
 *
 * @param string $val Chaine à echapper
 * @param string $serveur Nom du connecteur
 * @param string $type Peut contenir une declaration de type de champ SQL.
 *
 *     Exemple : `int NOT NULL` qui sert alors aussi à calculer le type d'échappement
 *
 * @return string La chaine echappee
 */
function sql_quote(string $val, string $serveur = '', string $type = ''): string {
	return '';
}

/**
 * Met à jour des enregistrements d'une table SQL
 *
 * Les valeurs ne sont pas échappées, ce qui permet de modifier une colonne
 * en utilisant la valeur d'une autre colonne ou une expression SQL.
 *
 * Il faut alors protéger avec sql_quote() manuellement les valeurs qui
 * en ont besoin.
 *
 * Dans les autres cas, préférer sql_updateq().
 *
 * @api
 * @see sql_updateq()
 *
 * @param string $table Nom de la table
 * @param array $exp Couples (colonne => valeur)
 * @param string|array $where Conditions a remplir (Where)
 * @param array $desc Tableau de description des colonnes de la table SQL utilisée
 *     (il sera calculé si nécessaire s'il n'est pas transmis).
 * @param string $serveur Nom de la connexion
 * @param bool|string $option
 *
 *     Peut avoir 3 valeurs :
 *
 *     - false : ne pas l'exécuter mais la retourner,
 *     - true : exécuter la requête
 *     - 'continue' : ne pas échouer en cas de serveur sql indisponible
 *
 * @return array|bool|string
 *     - string : texte de la requête si demandé
 *     - true si la requête a réussie, false sinon
 *     - array Tableau décrivant la requête et son temps d'exécution si var_profile est actif
 */
function sql_update(
    string $table,
    array $exp,
    array|string $where = '',
    array $desc = [],
    string $serveur = '',
    string|bool $option = true
): array|bool|string {
	return true;
}

/**
 * Insère une ligne dans une table
 *
 * @see sql_insertq()
 * @see sql_quote()
 * @note
 *   Cette fonction ne garantit pas une portabilité totale,
 *   et n'est là que pour faciliter des migrations de vieux scripts.
 *   Préférer sql_insertq.
 *
 * @param string $table Nom de la table SQL
 * @param string $noms Liste des colonnes impactées,
 * @param string $valeurs Liste des valeurs,
 * @param array $desc Tableau de description des colonnes de la table SQL utilisée
 *     (il sera calculé si nécessaire s'il n'est pas transmis).
 * @param string $serveur Nom du connecteur
 * @param bool|string $option Peut avoir 3 valeurs :
 *
 *     - false : ne pas l'exécuter mais la retourner,
 *     - true : exécuter la requête
 *     - 'continue' : ne pas échouer en cas de serveur sql indisponible
 *
 * @return bool|string
 *     - int|true identifiant de l'élément inséré (si possible), ou true, si réussite
 *     - texte de la requête si demandé,
 *     - False en cas d'erreur.
 */
function sql_insert(
    string $table,
    string $noms,
    string $valeurs,
    array $desc = [],
    string $serveur = '',
    string|bool $option = true
): int|string|bool {
	return true;
}

/**
 * Retourne le nombre de lignes d'une sélection
 *
 * Ramène seulement et tout de suite le nombre de lignes
 * Pas de colonne ni de tri à donner donc.
 *
 * @api
 * @see sql_count()
 * @example
 *     ```
 *     if (sql_countsel('spip_mots_liens', array(
 *         "objet=".sql_quote('article'),
 *         "id_article=".sql_quote($id_article)) > 0) {
 *             // ...
 *     }
 *     ```
 *
 * @param array|string $from Tables a consulter (From)
 * @param array|string $where Conditions a remplir (Where)
 * @param array|string $groupby critere de regroupement (Group by)
 * @param string|array $having Tableau ou chaine des des post-conditions à remplir (Having)
 * @param string $serveur Le serveur sollicite (pour retrouver la connexion)
 * @param bool|string $option
 *
 *    Peut avoir 3 valeurs :
 *
 *    - false -> ne pas l'executer mais la retourner,
 *    - continue -> ne pas echouer en cas de serveur sql indisponible,
 *    - true -> executer la requete.
 *
 * @return int|bool
 *     - Nombre de lignes de resultat
 *     - ou false en cas d'erreur
 */
function sql_countsel(
	array|string $from = [],
	array|string $where = [],
	array|string $groupby = [],
	array|string $having = [],
	string $serveur = '',
	string|bool $option = true
) {
	return 0;
}
