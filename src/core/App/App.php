<?php
/**
 * Main application instance
 *
 * App main logic starts here
 */

declare(strict_types=1);

namespace Kawa\App;

use Kawa\Bootstrappers\BootServiceProvider;
use Kawa\Bootstrappers\Helpers;
use Kawa\Bootstrappers\RegisterServiceProvider;
use Kawa\Foundation\KernelInterface;
use Kawa\View\Engines\EngineContract;

class App extends AppContainer
{

	/**
	 * Define if app is already booted
	 *
	 * @var boolean
	 */
	private bool $isBooted = false;

	/** @var KernelInterface */
	protected KernelInterface $kernel;

	/**
	 * List of app bootstrapers
	 *
	 * @var array<class-string>
	 */
	private array $bootstrappers = [
		Helpers::class,
		RegisterServiceProvider::class,
		BootServiceProvider::class,
	];

	/**
	 * Boot application
	 *
	 * @throws \DI\Definition\Exception\InvalidDefinition if no KernelInterface instantiated
	 * @return void
	 */
	public function boot() : void
	{
		if ($this->isBooted) {
			return;
		}

		$this->kernel = $this->get(KernelInterface::class);

		$this->runBootstrappers();
		$this->bootKernel();

		$this->isBooted = true;
	}

	/**
	 * Define app template engine contract
	 *
	 * @param string $engine
	 * @return void
	 */
	public function engine(string $engine) : void
	{
		$this->set(EngineContract::class, \DI\get($engine));
	}

	/**
	 * Boot application kernel
	 *
	 * @return void
	 */
	public function bootKernel() : void
	{
		add_action('pre_get_posts', [$this->kernel, 'preGetPosts']);
		add_action('kawa/response', [$this->kernel, 'handle']);
	}

	/**
	 * Run bootstrappers
	 *
	 * @return void
	 */
	public function runBootstrappers() : void
	{
		foreach ($this->getBootstrappers() as $bootstrapper) {
			$this->runBoostrapper($bootstrapper);
		}
	}

	/**
	 * Run bootstrapper
	 *
	 * @param string $bootstrapper
	 * @return void
	 */
	protected function runBoostrapper(string $bootstrapper) : void
	{
		if (method_exists($bootstrapper, 'run')) {
			$this->call([$bootstrapper, 'run'], [$this]);
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
