<?php

declare(strict_types=1);

namespace Theme\Providers;

use Kawa\App\Config;
use Kawa\Providers\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

	public function register()
	{
		//
	}

    public function boot()
	{
		$this->initConfig();
	}

	/**
	 * Init configuration
	 *
	 * @return void
	 */
	private function initConfig() : void
	{
		Config::init(get_template_directory());
	}
}
