<?php

declare(strict_types=1);

namespace Kawa\Queries;

use ArrayAccess;
use ArrayIterator;
use Countable;
use IteratorAggregate;
use Traversable;

class QueryCollection implements Countable, IteratorAggregate, ArrayAccess
{

	/**
	 * Countable array
	 *
	 * @var array
	 */
	protected array $countable = [];

	/**
	 * Count total amount of posts
	 *
	 * @return integer
	 */
	public function count(): int
	{
		return count($this->countable);
	}

	/**
	 * Make collection iterable
	 *
	 * @return Traversable
	 */
	public function getIterator(): Traversable
	{
		return new ArrayIterator($this->countable);
	}

	/**
	 * Does offset exists?
	 *
	 * @param mixed $offset
	 * @return boolean
	 */
	public function offsetExists(mixed $offset): bool
	{
		return isset($this->countable[$offset]);
	}

	/**
	 * Get offset
	 *
	 * @param mixed $offset
	 * @return mixed
	 */
	public function offsetGet(mixed $offset): mixed
	{
		return $this->offsetExists($offset) ?
			$this->countable[$offset] :
			null;
	}

	/**
	 * Set offset
	 *
	 * @param mixed $offset
	 * @param mixed $value
	 * @return void
	 */
	public function offsetSet(mixed $offset, mixed $value): void
	{
		$this->countable[$offset] = $value;
	}

	/**
	 * Inset offset
	 *
	 * @param mixed $offset
	 * @return void
	 */
	public function offsetUnset(mixed $offset): void
	{
		unset($this->countable[$offset]);
	}
}
