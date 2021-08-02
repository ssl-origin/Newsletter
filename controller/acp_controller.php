<?php
/**
 *
 * @package phpBB Extension - Newsletter
 * @copyright (c) 2020 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\newsletter\controller;

use messenger;
use phpbb\config\config;
use phpbb\db\driver\driver_interface;
use phpbb\extension\manager;
use phpbb\group\helper;
use phpbb\language\language;
use phpbb\log\log;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;

class acp_controller
{
	/** @var config */
	protected $config;

	/** @var driver_interface */
	protected $db;

	/** @var language */
	protected $language;

	/** @var log */
	protected $log;

	/** @var request */
	protected $request;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var helper */
	protected $group_helper;

	/** @var manager */
	protected $ext_manager;

	/** @var string */
	protected $php_ext;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $phpbb_admin_path;

	/** @var string */
	protected $tables;

	/** @var string */
	private $form_key = 'dmzx/newsletter';

	/**
	 * {@inheritdoc
	 */
	public function __construct(
		config $config,
		driver_interface $db,
		language $language,
		log $log,
		request $request,
		template $template,
		user $user,
		helper $group_helper,
		manager $ext_manager,
		$php_ext,
		$root_path,
		$adm_relative_path,
		array $tables
	)
	{
		$this->config = $config;
		$this->db = $db;
		$this->language = $language;
		$this->log = $log;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->group_helper = $group_helper;
		$this->ext_manager = $ext_manager;
		$this->php_ext = $php_ext;
		$this->root_path = $root_path;
		$this->adm_relative_path = $adm_relative_path;
		$this->phpbb_admin_path = $root_path . $adm_relative_path;
		$this->tables = $tables;
	}

	public function display_options()
	{
		$this->language->add_lang('acp_newsletter', 'dmzx/newsletter');
		$this->submit = $this->request->is_set_post('submit');
		$this->preview = $this->request->is_set_post('preview');
		$this->send_test_email = $this->request->is_set_post('send_test_email');
		add_form_key($this->form_key);

		$error = [];
		$author_id = 0;
		$usernames = $this->request->variable('usernames', '', true);
		$usernames = (!empty($usernames)) ? explode("\n", $usernames) : [];
		$group_id = $this->request->variable('g', 0);
		$title = $this->request->variable('title', '', true);
		$message = $this->request->variable('message', '', true);
		$url = $this->request->variable('url', '', true);
		$author = $this->request->variable('author', '', true);
		$priority = $this->request->variable('mail_priority_flag', MAIL_NORMAL_PRIORITY);
		$var_replace = $this->template_vars();

		if ($this->config['email_enable'])
		{
			if ($this->submit)
			{
				if (!check_form_key($this->form_key))
				{
					$error[] = $this->language->lang('FORM_INVALID');
				}

				if (empty($title))
				{
					$error[] = $this->language->lang('NO_NEWSLETTER_TITLE');
				}

				if (empty($message))
				{
					$error[] = $this->language->lang('NO_NEWSLETTER_MESSAGE');
				}

				if (!empty($author))
				{
					$sql = 'SELECT user_id
						FROM ' . $this->tables['users'] . "
						WHERE username_clean = '" . $this->db->sql_escape(utf8_clean_string($author)) . "'";
					$result = $this->db->sql_query($sql);
					$author_id = $this->db->sql_fetchfield('user_id');
					$this->db->sql_freeresult($result);

					if (!$author_id)
					{
						$error[] = $this->language->lang('NO_NEWSLETTER_AUTHOR');
					}
				}

				if (!count($error))
				{
					if (!empty($usernames))
					{
						$sql_ary = [
							'SELECT' => 'u.user_id, u.user_ip, u.user_email, u.username, u.username_clean, u.user_lang, u.user_jabber, u.user_notify_type',
							'FROM' => [
								$this->tables['users'] => 'u',
							],
							'WHERE' => $this->db->sql_in_set('username_clean', array_map('utf8_clean_string', $usernames)) . '
								AND user_allow_massemail = 1',
							'ORDER_BY' => 'user_lang, user_notify_type',
						];
					}
					else
					{
						if ($group_id)
						{
							$sql_ary = [
								'SELECT' => 'u.user_id, u.user_ip, u.user_email, u.username, u.username_clean, u.user_lang, u.user_jabber, u.user_notify_type',
								'FROM' => [
									$this->tables['users'] => 'u',
									$this->tables['user_group'] => 'ug',
								],
								'WHERE' => 'ug.group_id = ' . (int) $group_id . '
									AND ug.user_pending = 0
									AND u.user_id = ug.user_id
									AND u.user_allow_massemail = 1
									AND u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')',
								'ORDER_BY' => 'u.user_lang, u.user_notify_type',
							];
						}
						else
						{
							$sql_ary = [
								'SELECT' => 'u.user_id, u.user_ip, u.username, u.username_clean, u.user_email, u.user_jabber, u.user_lang, u.user_notify_type',
								'FROM' => [
									$this->tables['users'] => 'u',
								],
								'WHERE' => 'u.user_allow_massemail = 1
									AND u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')',
								'ORDER_BY' => 'u.user_lang, u.user_notify_type',
							];
						}
					}

					$sql = $this->db->sql_build_query('SELECT', $sql_ary);
					$result = $this->db->sql_query($sql);
					$row = $this->db->sql_fetchrow($result);

					if (!$row)
					{
						$this->db->sql_freeresult($result);
						trigger_error($this->language->lang('SOME_USERNAMES_NOT_FOUND', implode(', ', $usernames)) . adm_back_link($this->u_action), E_USER_WARNING);
					}

					$i = $j = 0;
					$email_list = [];
					do
					{
						if (($row['user_notify_type'] == NOTIFY_EMAIL && $row['user_email']) ||
							($row['user_notify_type'] == NOTIFY_IM && $row['user_jabber']) ||
							($row['user_notify_type'] == NOTIFY_BOTH && ($row['user_email'] || $row['user_jabber'])))
						{
							$email_list[$j][$i]['lang'] = $row['user_lang'];
							$email_list[$j][$i]['method'] = $row['user_notify_type'];
							$email_list[$j][$i]['email'] = $row['user_email'];
							$email_list[$j][$i]['name'] = $row['username'];
							$email_list[$j][$i]['jabber'] = $row['user_jabber'];
							$email_list[$j][$i]['user_id'] = $row['user_id'];
							$i++;
						}
					} while ($row = $this->db->sql_fetchrow($result));

					$this->db->sql_freeresult($result);

					for ($i = 0, $size = count($email_list); $i < $size; $i++)
					{
						$email_count = $email_list[$i];

						$trigger_message = $this->language->lang('NEWSLETTER_SEND', count($email_count));

						if (!empty($usernames) && count($usernames) !== count($email_count))
						{
							$found_usernames = $email_list[$i]['name'];
							foreach ($usernames as $username)
							{
								if (!$found_usernames)
								{
									$not_found_users[] = $username;
								}
							}
							$trigger_message .= $this->language->lang('SOME_USERNAMES_NOT_FOUND', implode(', ', $not_found_users));
						}

						for ($j = 0, $list_size = count($email_list[$i]); $j < $list_size; $j++)
						{
							$email_row = $email_list[$i][$j];
							$this->email_member($email_row['user_id'], $message, $title, $author, $url, $priority);
						}

						$userlist = array_map(function ($entry)
						{
							return $entry['name'];
						},	$email_list[$i]);

						$this->log->add('admin', $this->user->data['user_id'], $this->user->data['session_ip'], 'LOG_NEWSLETTER_EMAIL', false, [implode(', ', $userlist)]);
					}
					unset($email_list);

					$u_action = $this->u_action;
					trigger_error($trigger_message . adm_back_link($this->u_action));
				}
			}

			if ($this->preview)
			{
				$this->template->assign_var('PREVIEW', htmlspecialchars_decode($message));
			}

			if ($this->send_test_email)
			{
				$this->email_member($this->user->data['user_id'], $message, $this->language->lang('NEWSLETTER_TEST_EMAIL_SENT'), $author, $url, $priority);
				trigger_error($this->language->lang('NEWSLETTER_TEST_EMAIL_SENT') . adm_back_link($this->u_action));
			}
		}

		$sql = 'SELECT group_id, group_name
			FROM ' . $this->tables['groups'] . '
			WHERE ' . $this->db->sql_in_set('group_name', ['BOTS', 'GUESTS'], true);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$this->template->assign_block_vars('groups', [
				'ID' => $row['group_id'],
				'NAME' => $this->group_helper->get_name($row['group_name']),
			]);
		}
		$this->db->sql_freeresult($result);

		$s_priority_options = '<option value="' . MAIL_LOW_PRIORITY . '">' . $this->language->lang('MAIL_LOW_PRIORITY') . '</option>';
		$s_priority_options .= '<option value="' . MAIL_NORMAL_PRIORITY . '" selected="selected">' . $this->language->lang('MAIL_NORMAL_PRIORITY') . '</option>';
		$s_priority_options .= '<option value="' . MAIL_HIGH_PRIORITY . '">' . $this->language->lang('MAIL_HIGH_PRIORITY') . '</option>';

		foreach ($var_replace as $var)
		{
			$this->template->assign_block_vars('var_variables', [
				'VAR' => $var,
				'INFO' => $this->language->lang('NEWSLETTER_' . str_replace(['{', '}'], '', $var)),
			]);
		}

		$url_board_settings = append_sid($this->phpbb_admin_path . 'index.' . $this->php_ext, 'i=acp_board&amp;mode=email');
		$email_settings = $this->language->lang('NO_NEWSLETTER_EMAIL_ENABLE', '<a href="' . $url_board_settings . '">', '</a>');

		$use_html = ($this->ext_manager->is_enabled('dmzx/htmlemail')) ? true : false;

		$this->template->assign_vars([
			'U_ACTION' => $this->u_action,
			'S_WARNING' => (!empty($error)) ? true : false,
			'WARNING_MSG' => (!empty($error)) ? implode('<br />', $error) : '',
			'USERNAMES' => implode("\n", $usernames),
			'U_FIND_USERNAME' => append_sid("{$this->root_path}memberlist.{$this->php_ext}", 'mode=searchuser&amp;form=acp_newsletter&amp;field=usernames'),
			'U_FIND_AUTHOR' => append_sid("{$this->root_path}memberlist.{$this->php_ext}", 'mode=searchuser&amp;form=acp_newsletter&amp;field=author'),
			'TITLE' => $title,
			'MESSAGE' => $message,
			'URL' => $url,
			'AUTHOR' => $author,
			'S_PRIORITY_OPTIONS' => $s_priority_options,
			'NO_NEWSLETTER_EMAIL_ENABLE' => $email_settings,
			'S_NEWSLETTER_ENABLE' => $this->config['email_enable'],
			'NEWSLETTER_HTML_PLAIN' => (($use_html) ? $this->language->lang('NEWSLETTER_HTML') : $this->language->lang('NEWSLETTER_PLAIN_TEXT')),
			'NEWSLETTER_VERSION' => $this->config['newsletter_version'],
		]);
	}

	public function email_member($member_id, $message, $title, $author, $url, $priority)
	{
        $emails_sent = 0;

		$sql = 'SELECT user_id, username, user_email, user_lang, user_ip
			FROM '. $this->tables['users'] .'
			WHERE '. $this->db->sql_in_set('user_id', $member_id);
		$result = $this->db->sql_query($sql);

		$users = [];

		while ($row = $this->db->sql_fetchrow($result))
		{
			$users[] = $row;
		}

		$this->db->sql_freeresult($result);

		if (!class_exists('messenger'))
		{
			include($this->root_path . 'includes/functions_messenger.' . $this->php_ext);
		}

		$messenger = new \messenger();

		$xhead_username = ($this->config['board_contact_name']) ? $this->config['board_contact_name'] : $this->user->lang('ADMINISTRATOR');

		// mail headers
		$messenger->headers('X-AntiAbuse: Board servername - ' . $this->config['server_name']);
		$messenger->headers('X-AntiAbuse: Username - ' . $xhead_username);
		$messenger->headers('X-AntiAbuse: User_id - ' . $this->user->data['user_id']);

		// mail content...
		$messenger->from($this->config['board_contact']);

		foreach ($users as $user)
		{
			$var_replace = $this->template_vars();
			$str_replace = [$this->config['sitename'], generate_board_url(), $user['username'], $user['user_email'], $url, $author];
			$message = str_replace($var_replace, $str_replace, $message);

			$use_html = ($this->ext_manager->is_enabled('dmzx/htmlemail')) ? true : false;
			($use_html) ? $messenger->set_mail_html(true) : null;

			$templ = 'newsletter.' . (($use_html) ? 'html' : 'txt');
			$messenger->template('@dmzx_newsletter/' . $templ, $user['user_lang']);
			$messenger->to($user['user_email'], $user['username']);
			$messenger->set_mail_priority($priority);
			$messenger->assign_vars([
				'MESSAGE' => htmlspecialchars_decode($message),
				'SUBJECT' => $title,
			]);
            $mail_sent = $messenger->send(NOTIFY_EMAIL, false);

            if ($mail_sent)
            {
                $emails_sent++;
            }
            $messenger->reset();
		}
        $messenger->save_queue();
	}

	public function template_vars()
	{
		return [
			'{SITENAME}',
			'{BOARDURL}',
			'{USERNAME}',
			'{USER_EMAIL}',
			'{URL}',
			'{AUTHOR}'
		];
	}

	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
