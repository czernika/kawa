<?php

declare(strict_types=1);

namespace Kawa\Providers;

use Carbon_Fields\Carbon_Fields;

class MetaFieldsServiceProvider extends ServiceProvider
{

	/**
	 * @inheritDoc
	 */
	public function boot()
	{
		add_action('after_setup_theme', [$this, 'bootCarbonFields']);
	}

	/**
	 * Boot Carbon Fields plugin
	 *
	 * @link https://docs.carbonfields.net/quickstart.html
	 * @return void
	 */
	public function bootCarbonFields() : void
	{
		if (!class_exists(Carbon_Fields::class)) {
			return;
		}

		Carbon_Fields::boot();
	}
}
