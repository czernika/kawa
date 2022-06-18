<?php

declare(strict_types=1);

namespace Kawa\Models;

abstract class BaseModel
{

	abstract protected function init();

	public function __get(string $name) : mixed
	{
		return $this->getPostProperty($name);
	}

	/**
	 * Get property from post object
	 *
	 * @param string $name
	 * @return mixed
	 */
	protected function getPostProperty(string $name) : mixed
	{
		if ($this->hasKey($name)) {
			$name = $this->getKey($name);
		}

		return $this->post->$name;
	}

	/**
	 * Get list of allowed properties
	 *
	 * @return array
	 */
	protected function getAllowedKeys() : array
	{
		return PostMapper::getAllowedKeys();
	}

	/**
	 * Does property exists as allowed
	 *
	 * @param string $key
	 * @return boolean
	 */
	protected function hasKey(string $key) : bool
	{
		return array_key_exists($key, $this->getAllowedKeys());
	}

	/**
	 * Get value from allowed properties
	 *
	 * @param string $key
	 * @return string|null
	 */
	protected function getKey(string $key) : ?string
	{
		if ($this->hasKey($key)) {
			return $this->getAllowedKeys()[$key];
		}

		return null;
	}
}
