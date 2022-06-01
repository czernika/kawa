<?php
/**
 * Define that route should implement uri methods
 */

declare(strict_types=1);

namespace Kawa\Routing\Contracts;

interface HasUriContract
{
    /**
	 * Set route uri
	 *
	 * @param string $uri
	 * @return static
	 */
	public function setUri(string $uri) : static;

	/**
	 * Get route prefixed uri
	 *
	 * @return string
	 */
	public function getUri() : string;

	/**
	 * Add custom regex pattern for current route
	 *
	 * @param array $regex
	 * @return void
	 */
	public function where(array $regex) : void;
}
