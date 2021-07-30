<?php
/**
 *
 * @package phpBB Extension - Newsletter
 * @copyright (c) 2020 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\newsletter\acp;

class main_info
{
	public function module()
	{
		return [
			'filename' => '\dmzx\newsletter\acp\main_module',
			'title' => 'ACP_DMZX_NEWSLETTER_TITLE',
			'modes' => [
				'newsletter' => [
					'title' => 'ACP_DMZX_NEWSLETTER_TITLE',
					'auth' => 'ext_dmzx/newsletter && acl_a_board',
					'cat' => ['ACP_GENERAL_TASKS']
				],
			],
		];
	}
}
