<?php

declare(strict_types=1);

namespace Kawa\Queries;

class Builder
{
	public function __construct(
		protected string $as,
		protected array $args = [],
	) {}

	/**
	 * Get query arguments
	 *
	 * @return array
	 */
	public function getQueryArgs() : array
	{
		return $this->args;
	}

	/**
	 * Set query argument
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public function setQueryArgument(string $key, $value) : void
	{
		$this->args[$key] = $value;
	}

	/**
	 * Merge query arguments
	 *
	 * @param array $args
	 * @return void
	 */
	public function mergeQueryArguments(array $args) : void
	{
		$this->args = array_merge($this->args, $args);
	}
}
