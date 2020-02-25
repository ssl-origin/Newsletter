<?php
/**
*
* @package phpBB Extension - Newsletter
* @copyright (c) 2020 dmzx - https://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace dmzx\newsletter\migrations;

class m1_acp_module extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		$sql = 'SELECT module_id
			FROM ' . $this->table_prefix . "modules
			WHERE module_class = 'acp'
				AND module_langname = 'ACP_DMZX_NEWSLETTER_TITLE'";
		$result = $this->db->sql_query($sql);
		$module_id = (int) $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id;
	}

	static public function depends_on()
	{
		return ['\phpbb\db\migration\data\v330\v330'];
	}

	public function update_data()
	{
		return [
			['config.add', ['newsletter_version', '1.0.0']],
			['module.add', [
				'acp',
				'ACP_GENERAL_TASKS',
				[
					'module_basename'	=> '\dmzx\newsletter\acp\main_module',
					'modes'				=> ['newsletter'],
				],
			]],
		];
	}
}
