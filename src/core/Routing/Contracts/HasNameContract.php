<?php

declare(strict_types=1);

namespace Kawa\Routing\Contracts;

interface HasNameContract
{

	/**
	 * Set route name
	 *
	 * @param string $name
	 * @return static
	 */
	public function setName(string $name) : static;

	/**
	 * Get route name
	 *
	 * @return string|null
	 */
	public function getName() : ?string;
}
