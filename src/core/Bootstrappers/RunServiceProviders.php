<?php

declare(strict_types=1);

namespace Kawa\Bootstrappers;

use InvalidArgumentException;
use Kawa\App\App;
use Kawa\Foundation\KernelInterface;
use Kawa\Providers\ContainerServiceProvider;

abstract class RunServiceProviders implements BootInterface
{

	/**
	 * List of allowed service provider default methods
	 *
	 * @var string[]
	 */
	protected array $allowed = ['boot', 'register'];

	/**
	 * List of app service providers
	 *
	 * @var array
	 */
	protected array $appServiceProviders = [
		ContainerServiceProvider::class,
	];

	/**
	 * Run register or boot method of service provided
	 *
	 * @param App $app
	 * @param string $method
	 * @return void
	 */
    protected function runAs(App $app, string $method) : void
	{
		if (!in_array($method, $this->allowed, true)) {
			throw new InvalidArgumentException("$method method is not allowed");
		}

		foreach ($this->getProviders($app) as $provider) {
			if (method_exists($provider, $method)) {
				$app->call([$provider, $method]);
			}
		}
	}

	/**
	 * Get list of all service providers
	 *
	 * @return array
	 */
	public function getProviders(App $app) : array
	{
		/** @var KernelInterface */
		$kernel = $app->get(KernelInterface::class);

		return array_merge($this->appServiceProviders, $kernel->getProviders());
	}

	/**
	 * @inheritDoc
	 */
	abstract public function run(App $app) : void;
}
