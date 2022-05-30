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

class AppContainer implements AppContainerContract
{
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
		$this->container->set($key, $value);
	}

	/**
	 * @inheritDoc
	 */
	public function make(string $key, array $params = []) : mixed
	{
		return $this->container->make($key, $params);
	}

	/**
	 * @inheritDoc
	 */
	public function call(callable|array $callable, array $params = []) : mixed
	{
		return $this->container->call($callable, $params);
	}
}
