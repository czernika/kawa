<?php

declare(strict_types=1);

namespace Kawa\Bootstrappers;

use Kawa\App\App;

interface BootInterface
{
	/**
	 * Run bootstrapper
	 *
	 * @param App $app
	 * @return void
	 */
    public function run(App $app) : void;
}
