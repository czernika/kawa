<?php

declare(strict_types=1);

namespace Kawa\Bootstrappers;

use Kawa\App\App;

class RegisterServiceProvider extends RunServiceProviders
{
	/**
	 * @inheritDoc
	 */
    public function run(App $app): void
	{
		$this->runAs($app, 'register');
	}
}
