<?php
/**
 * Application Service Container
 *
 * Extends PHP DI 6 Container
 *
 * @link https://php-di.org/doc
 */

declare(strict_types=1);

namespace Kawa\App;

use DI\Container;
use Kawa\App\Exceptions\AppContainerException;

class AppContainer implements AppContainerContract
{

	/**
	 * List of app singleton keys
	 *
	 * @var string[]
	 */
	protected array $singletons = [];

	/**
	 * List of app bindings keys
	 *
	 * @var string[]
	 */
	protected array $bindings = [];

	/**
	 * List of all app bindings - both singletons andd regular bindings
	 *
	 * @var string[]
	 */
	protected array $allBindings = [];

	public function __construct(
		private Container $container,
	) {}

	/**
	 * Return Container instance
	 *
	 * @return Container
	 */
	public function container() : Container
	{
		return $this->container ?: new Container();
	}

	/**
	 * @inheritDoc
	 */
	public function get(string $key) : mixed
	{
		if (in_array($key, $this->bindings, true)) {
			return $this->make($key);
		}

		return $this->container->get($key);
	}

	/**
	 * @inheritDoc
	 */
	public function has(string $key) : bool
	{
		return $this->container->has($key);
	}

	/**
	 * @inheritDoc
	 */
	public function set(string $key, $value) : void
	{
		if (in_array($key, $this->allBindings, true)) {
			throw new AppContainerException("$key key already exists within app container");
		}

		$this->allBindings[] = $key;
		$this->container->set($key, $value);
	}

	/**
	 * @inheritDoc
	 */
	public function make(string $key, array $params = []) : mixed
	{
		if (in_array($key, $this->singletons, true)) {
			return $this->get($key);
		}

		return $this->container->make($key, $params);
	}

	/**
	 * @inheritDoc
	 */
	public function call(callable|array $callable, array $params = []) : mixed
	{
		return $this->container->call($callable, $params);
	}

	/**
	 * @inheritDoc
	 */
	public function singleton(string $key, $value) : void
	{
		$this->singletons[] = $key;
		$this->set($key, $value);
	}

	/**
	 * @inheritDoc
	 */
	public function bind(string $key, $value) : void
	{
		$this->bindings[] = $key;
		$this->set($key, $value);
	}
}
