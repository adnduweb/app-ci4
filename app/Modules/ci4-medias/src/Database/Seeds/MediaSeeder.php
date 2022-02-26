<?php namespace Adnduweb\Ci4Medias\Database\Seeds;

use Adnduweb\Ci4Core\Models\LanguageModel;
use Adnduweb\Ci4Core\Models\TabModel;
use Adnduweb\Ci4Core\Models\SettingModel;

class MediaSeeder extends \CodeIgniter\Database\Seeder
{
	public function run()
	{
		$templates = [
			[
				'name'      => 'perPage',
				'scope'     => 'user',
				'content'   => '8',
				'summary'   => 'Number of items to show per page',
				'protected' => 1,
			],
			[
				'name'      => 'filesFormat',
				'scope'     => 'user',
				'content'   => 'cards',
				'protected' => 0,
				'summary'   => 'Display format for listing files',
			],
			[
				'name'      => 'filesSort',
				'scope'     => 'user',
				'content'   => 'filename',
				'protected' => 0,
				'summary'   => 'Sort field for listing files',
			],
			[
				'name'      => 'filesOrder',
				'scope'     => 'user',
				'content'   => 'asc',
				'protected' => 0,
				'summary'   => 'Sort order for listing files',
			],
		];

		// Check for each template and create it if it is missing
		foreach ($templates as $template)
		{
			if (! model(SettingModel::class)->where('name', $template['name'])->first())
			{
				model(SettingModel::class)->insert($template);
			}
		}
	}
}