<?php

declare(strict_types=1);

namespace Kawa\Support\Traits;

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
