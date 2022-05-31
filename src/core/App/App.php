<?php
/**
 * Main application instance
 *
 * App main logic starts here
 */

declare(strict_types=1);

namespace Kawa\App;

use Kawa\Bootstrappers\Helpers;

class App extends AppContainer
{

	/**
	 * Define if app is already booted
	 *
	 * @var boolean
	 */
	private bool $isBooted = false;

	/**
	 * List of app bootstrapers
	 *
	 * @var array<class-string>
	 */
	private array $bootstrappers = [
		Helpers::class,
	];

	/**
	 * Boot application
	 *
	 * @return void
	 */
	public function boot() : void
	{
		if ($this->isBooted) {
			return;
		}

		$this->runBootstrappers();

		$this->isBooted = true;
	}

	/**
	 * Run bootstrappers
	 *
	 * @return void
	 */
	public function runBootstrappers() : void
	{
		$bootstrappers = $this->getBootstrappers();
		foreach ($bootstrappers as $bootstrapper) {
			if (method_exists($bootstrapper, 'run')) {
				$this->call([$bootstrapper, 'run'], [$this]);
			}
		}
	}

	/**
	 * Get list of bootstrappers
	 *
	 * @return array
	 */
	public function getBootstrappers() : array
	{
		return $this->bootstrappers;
	}
}
