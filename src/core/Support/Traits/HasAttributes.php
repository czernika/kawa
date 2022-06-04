<?php

declare(strict_types=1);

namespace Kawa\Support\Traits;

use Illuminate\Support\Arr;

trait HasAttributes
{

	/**
	 * Attributes
	 *
	 * @var array
	 */
	protected array $attributes = [];

	/**
	 * Get attributes
	 *
	 * @return array
	 */
	public function getAttributes() : array
	{
		return $this->attributes;
	}

	/**
	 * Get attribute
	 *
	 * @param string $key
	 * @return mixed
	 */
	public function getAttribute(string $key) : mixed
	{
		if (isset($this->attributes[$key])) {
			return $this->attributes[$key];
		}

		return null;
	}

	/**
	 * Set attributes
	 *
	 * @param array $attributes
	 * @return void
	 */
	public function setAttributes(array $attributes) : void
	{
		$this->attributes = $attributes;
	}

	/**
	 * Merge attributes into array
	 *
	 * @param string $key
	 * @param array $attributes
	 * @return static
	 */
	public function mergeAttributes(string $key, array $attributes) : static
	{
		$oldAttributes = Arr::wrap($this->getAttribute($key));
		return $this->addAttribute($key, array_merge($oldAttributes, $attributes));
	}

	/**
	 * Define does this attribute exists or not
	 *
	 * @param string $key
	 * @return boolean
	 */
	public function hasAttribute(string $key) : bool
	{
		return null !== $this->getAttribute($key);
	}

	/**
	 * Add attribute
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return static
	 */
	public function addAttribute(string $key, mixed $value) : static
	{
		$this->attributes[$key] = $value;
		return $this;
	}
}
