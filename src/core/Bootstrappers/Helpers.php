<?php
/**
 * Instantiate helpers, facades and debugger
 */

declare(strict_types=1);

namespace Kawa\Bootstrappers;

use Kawa\App\App;
use Kawa\Support\Helper;

class Helpers implements BootInterface
{
	/**
	 * @inheritDoc
	 */
	public function run(App $app) : void
	{
		Helper::instantiate($app);
	}
}
