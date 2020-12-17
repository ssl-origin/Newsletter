<?php
/**
*
* @package phpBB Extension - Newsletter
* @copyright (c) 2020 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\newsletter\acp;

class main_module
{
	public $page_title;
	public $tpl_name;
	public $u_action;

	public function main($id, $mode)
	{
		global $phpbb_container, $request;

		/** @var \dmzx\newsletter\controller\acp_controller $acp_controller */
		$acp_controller = $phpbb_container->get('dmzx.newsletter.controller.acp');

		// Requests
		$action = $request->variable('action', '');

		/** @var \phpbb\language\language $language */
		$language = $phpbb_container->get('language');

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'acp_newsletter';

		// Set the page title for our ACP page
		$this->page_title = $language->lang('ACP_DMZX_NEWSLETTER_TITLE');

		// Make the $u_action url available in our ACP controller
		$acp_controller->set_page_url($this->u_action);

		// Load the display options handle in our ACP controller
		$acp_controller->display_options();
	}
}
