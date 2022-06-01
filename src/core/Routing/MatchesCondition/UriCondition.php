<?php

declare(strict_types=1);

namespace Kawa\Routing\MatchesCondition;

use Kawa\Foundation\Request;
use Kawa\Routing\UriRoute;
use Kawa\Support\Str;

class UriCondition implements ConditionInterface
{

	/**
	 * Regular expression patterns
	 *
	 * @var array
	 */
	private array $patterns = [
		':all' => '(.*)',
        ':any' => '([^/]+)',
        ':id' => '(\d+)',
        ':int' => '(\d+)',
        ':number' => '([+-]?([0-9]*[.])?[0-9]+)',
        ':float' => '([+-]?([0-9]*[.])?[0-9]+)',
        ':bool' => '(true|false|1|0)',
        ':string' => '([\w\-_]+)',
        ':slug' => '([\w\-_]+)',
        ':uuid' => '([0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12})',
        ':date' => '([0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1]))',
	];

	public function __construct(
		private Request $request,
		private UriRoute $route,
	) {}

	/**
	 * @inheritDoc
	 */
    public function isSatisfied(): bool
	{
		// HTTP-method is not the same
		if ($this->route->getMethod() !== $this->request->getMethod()) {
			return false;
		}

		// Direct match
		if ($this->route->getUri() === $this->request->getPathInfo()) {
			return true;
		}

		// Regex
		if (preg_match('#^'.$this->getUriPattern().'\/?$#', $this->getRequestUri(), $matches)) {
			return true;
		}

		return false;
	}

	/**
	 * Get regex patterns
	 *
	 * @return array
	 */
	public function getPatterns() : array
	{
		return $this->patterns;
	}

	/**
	 * Get request uri
	 *
	 * @return string
	 */
	private function getRequestUri() : string
	{
		return rawurldecode($this->request->getPathInfo());
	}

	/**
	 * Get request uri
	 *
	 * @return string
	 */
	private function getUriPattern() : string
	{
		return Str::swap($this->getPatterns(), $this->route->getUri());
	}
}
