<?php

declare(strict_types=1);

namespace Theme\Http;

use Kawa\Foundation\Kernel as FoundationKernel;
use Theme\Providers\RoutesServiceProvider;

class Kernel extends FoundationKernel
{

	/**
	 * List of theme service providers
	 *
	 * @var array
	 */
	protected array $providers = [
		RoutesServiceProvider::class,
	];
}
