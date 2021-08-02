<?php
/**
 *
 * @package phpBB Extension - Newsletter
 * @copyright (c) 2020 dmzx - https://www.dmzx-web.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace dmzx\newsletter\migrations;

use phpbb\db\migration\migration;

class newsletter_v103 extends migration
{
	static public function depends_on()
	{
		return [
			'\dmzx\newsletter\migrations\newsletter_v102',
		];
	}

	public function update_data()
	{
		return [
			['config.update', ['newsletter_version', '1.0.3']],
		];
	}
}
