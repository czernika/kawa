<?php

declare(strict_types=1);

namespace Kawa\Foundation;

use Kawa\Routing\Exceptions\RouteNotFoundException;
use Kawa\Routing\Route;

interface KernelInterface
{

	/**
	 * Handle upcoming request
	 *
	 * @param Request $request
	 * @return void
	 */
	public function handle(Request $request) : void;

	/**
	 * Get list of theme service providers
	 *
	 * @return array
	 */
	public function getProviders() : array;

	/**
	 * Get satisfied route according to request
	 *
	 * @param Request $request
	 * @throws RouteNotFoundException no route was satisfied
	 * @return Route
	 */
	public function getSatisfiedRoute(Request $request) : Route;
}
