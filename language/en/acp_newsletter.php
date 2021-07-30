<?php
/**
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
	'NEWSLETTER_DESC' => 'Here you can send a newsletter to either all of your users or specific users or groups.',
	'COMPOSE' => 'Compose newsletter',
	'ALL_USERS' => 'All users',
	'SEND_TO_GROUP' => 'Send to group',
	'SEND_TO_USERS' => 'Send to users',
	'SEND_TO_USERS_EXPLAIN' => 'Entering names here will override any group selected above. Enter each username on a new line.',
	'TITLE' => 'Newsletter email title',
	'MESSAGE_EXPLAIN' => 'Message of newsletter.',
	'URL' => 'URL',
	'URL_EXPLAIN' => 'Enter URL for redirection or image.',
	'AUTHOR_EXPLAIN' => 'Enter author of the newsletter. Leave blank for generic newsletter without author.',
	'SEND_NEWSLETTER' => 'Send newsletter',
	'NO_NEWSLETTER_TITLE' => 'You have to specify newsletter title.',
	'NO_NEWSLETTER_MESSAGE' => 'You have to specify newsletter message.',
	'NO_NEWSLETTER_AUTHOR' => 'Author does not exist.',
	'NO_NEWSLETTER_EMAIL_ENABLE' => 'Board-wide emails are disabled.<br>Go to %sEmail settings%s to enable the Board-wide emails.<br>Settings will be shown when Board-wide emails are enabled.',
	'NEWSLETTER_SEND' => [
		1 => 'Your newsletter has been sent to 1 user.',
		2 => 'Your newsletter has been sent to %d users.',
	],
	'SOME_USERNAMES_NOT_FOUND' => 'Some users were not found:<br>%s',
	'MAIL_HIGH_PRIORITY' => 'High',
	'MAIL_LOW_PRIORITY' => 'Low',
	'MAIL_NORMAL_PRIORITY' => 'Normal',
	'MAIL_PRIORITY' => 'Mail priority',
	'NEWSLETTER_SEND_TEST_EMAIL' => 'Send a test email',
	'NEWSLETTER_TEST_EMAIL_SENT' => 'The test newsletter email has been sent.',
	'NEWSLETTER_VARIABLES' => 'Newsletter Variables (click to insert)',
	'NEWSLETTER_SITENAME' => 'Board name',
	'NEWSLETTER_BOARDURL' => 'Board address',
	'NEWSLETTER_USERNAME' => 'Username of user who receive newsletter',
	'NEWSLETTER_USER_EMAIL' => 'E-mail address of user who receive newsletter',
	'NEWSLETTER_URL' => 'URL, if above URL field is entered.',
	'NEWSLETTER_AUTHOR' => 'Author, if above Author field is entered.',
	'NEWSLETTER_TEST_EMAIL' => 'Send a test email',
	'NEWSLETTER_TEST_EMAIL_EXPLAIN' => 'This will send a test email to the address defined in your account.',
	'NEWSLETTER_HTML' => 'You can use HTML.',
	'NEWSLETTER_PLAIN_TEXT' => 'Plain text only.',
	'NEWSLETTER_VERSION' => 'Version',
]);
