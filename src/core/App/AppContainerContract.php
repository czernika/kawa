<?php
/**
 * App container contract
 */

declare(strict_types=1);

namespace Kawa\App;

interface AppContainerContract
{
	/**
	 * Get binded value
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function get(string $key) : mixed;

	/**
	 * Define does container has binded value
	 *
	 * @param string $key
	 * @return boolean
	 */
	public function has(string $key) : bool;

	/**
	 * Add new binding into container
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public function set(string $key, $value) : void;

	/**
	 * Resolve new instance from container
	 *
	 * @param string $key
	 * @param array $params
	 * @return mixed
	 */
	public function make(string $key, array $params = []) : mixed;

	/**
	 * Resolve callable
	 *
	 * @param callable|array $callable
	 * @param array $params
	 * @return mixed
	 */
	public function call(callable|array $callable, array $params = []) : mixed;
}
