<?php
/**
 * Application Kernel
 *
 * Converts upcoming request into appropriate response
 */

declare(strict_types=1);

namespace Kawa\Foundation;

use Kawa\Routing\Router;
use Kawa\Support\Facades\Route;

class Kernel implements KernelInterface
{

	/**
	 * List of theme service providers
	 *
	 * @var array
	 */
	protected array $providers = [];

	public function __construct(protected Router $router)
	{

	}

	/**
	 * @inheritDoc
	 */
	public function handle(Request $request) : void
	{

		echo 'Happy End!';
	}

	/**
	 * @inheritDoc
	 */
	public function getProviders() : array
	{
		return $this->providers;
	}
}
