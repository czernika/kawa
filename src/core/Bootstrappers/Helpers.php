<?php
/**
 * Instantiate helpers, facades and other
 */

declare(strict_types=1);

namespace Kawa\Bootstrappers;

use Kawa\App\App;
use Kawa\Routing\HandlerDispatcher;
use Kawa\Support\Facades\Facade;
use Kawa\Support\Helper;

class Helpers implements BootInterface
{
	/**
	 * @inheritDoc
	 */
	public function run(App $app) : void
	{
		Facade::instantiate($app);
		Helper::instantiate($app);
		HandlerDispatcher::instantiate($app);
	}
}
