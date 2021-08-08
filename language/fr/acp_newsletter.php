<?php
/**
*
* Nesletter [French]
*
* @package phpBB Extension - Newsletter
* @copyright (c) 2020 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters for use
// ’ » “ ” …

$lang = array_merge($lang, [
	'NEWSLETTER_DESC'				=> 'Ici, vous pouvez envoyer une newsletter à tous vos utilisateurs ou à des utilisateurs dédiés ou groupes spécifiques.',
	'COMPOSE'						=> 'Composer une newsletter',
	'ALL_USERS'						=> 'Tous les utilisateurs',
	'SEND_TO_GROUP'					=> 'Envoyer au groupe',
	'SEND_TO_USERS'					=> 'Envoyer aux utilisateurs',
	'SEND_TO_USERS_EXPLAIN'			=> 'La saisie de noms ici remplacera tout groupe sélectionné ci-dessus. Entrez chaque nom d‘utilisateur sur une nouvelle ligne.',
	'TITLE'							=> 'Titre de l‘e-mail de la newsletter',
	'MESSAGE_EXPLAIN'				=> 'Message de la newsletter.',
	'URL'							=> 'URL',
	'URL_EXPLAIN'					=> 'Entrez l‘URL pour la redirection ou l‘image.',
	'AUTHOR_EXPLAIN'				=> 'Entrez l‘auteur de la newsletter. Laisser vide pour une newsletter générique sans auteur.',
	'SEND_NEWSLETTER'				=> 'Envoyer la newsletter',
	'NO_NEWSLETTER_TITLE'			=> 'Vous devez spécifier le titre de la newsletter.',
	'NO_NEWSLETTER_MESSAGE'			=> 'Vous devez spécifier le message de la newsletter.',
	'NO_NEWSLETTER_AUTHOR'			=> 'Ce membre n‘existe pas.',
	'NO_NEWSLETTER_EMAIL_ENABLE'	=> 'L’envoi de courriel via le forum est désactivé.<br>Aller à %sParamètres des couriels%s pour activer l’envoi de courriel via le forum.<br>Les paramètres seront affichés lorsque l’envoi de courriel via le forum sera activé.',
	'NEWSLETTER_SEND'				=> [
		1	=> 'Votre newsletter a été envoyée à 1 utilisateur.',
		2	=> 'Votre newsletter a été envoyée à %d utilisateurs.',
	],
	'SOME_USERNAMES_NOT_FOUND'		=> 'Certains utilisateurs n‘ont pas été trouvés :<br>%s',
	'MAIL_HIGH_PRIORITY'			=> 'Haute',
	'MAIL_LOW_PRIORITY'				=> 'Basse',
	'MAIL_NORMAL_PRIORITY'			=> 'Normale',
	'MAIL_PRIORITY'					=> 'Priorité de l‘envoie',
	'NEWSLETTER_SEND_TEST_EMAIL'	=> 'Envoyer un e-mail de test',
	'NEWSLETTER_TEST_EMAIL_SENT'	=> 'L‘e-mail de la newsletter de test a été envoyé.',
	'NEWSLETTER_VARIABLES'			=> 'Variables de la newsletter (cliquez pour insérer)',
	'NEWSLETTER_SITENAME'			=> 'Nom du forum',
	'NEWSLETTER_BOARDURL'			=> 'URL du forum',
	'NEWSLETTER_USERNAME'			=> 'Nom d‘utilisateur du menbre qui reçoit la newsletter',
	'NEWSLETTER_USER_EMAIL'			=> 'Adresse e-mail de l‘utilisateur qui reçoit la newsletter',
	'NEWSLETTER_URL'				=> 'URL, si le champ URL ci-dessus est entré.',
	'NEWSLETTER_AUTHOR'				=> 'Auteur, si le champ Auteur ci-dessus est entré.',
	'NEWSLETTER_TEST_EMAIL'			=> 'Envoyer un e-mail de test',
	'NEWSLETTER_TEST_EMAIL_EXPLAIN'	=> 'Cela enverra un e-mail de test à l‘adresse définie dans votre profil.',
	'NEWSLETTER_HTML'				=> 'Vous pouvez utiliser le HTML.',
	'NEWSLETTER_PLAIN_TEXT'			=> 'Texte brut uniquement.',
	'NEWSLETTER_VERSION'			=> 'Version',
]);

