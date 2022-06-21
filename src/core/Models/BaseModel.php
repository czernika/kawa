<?php

declare(strict_types=1);

namespace Kawa\Models;

abstract class BaseModel
{

	/**
	 * Define main model properties
	 *
	 * @return void
	 */
	abstract protected function init();

	/**
	 * Get id
	 *
	 * @return int
	 */
	public function id() : int
	{
		return $this->id;
	}

	/**
	 * Get title
	 *
	 * @return string
	 */
	public function title() : string
	{
		return $this->title;
	}

	/**
	 * Get list of allowed properties
	 *
	 * @return array
	 */
	abstract protected function getAllowedKeys() : array;

	public function __get(string $name) : mixed
	{
		return $this->getModelProperty($name);
	}

	/**
	 * Get property from model object
	 *
	 * @param string $name
	 * @return mixed
	 */
	protected function getModelProperty(string $name) : mixed
	{
		if (method_exists($this, $name)) {
			return $this->$name();
		}

		if ($this->hasKey($name)) {
			$name = $this->getKey($name);
		}

		return $this->entity->$name;
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
