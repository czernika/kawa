<?php

declare(strict_types=1);

namespace Kawa\Foundation;

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
}
