<?php
/**
 * Kawa Framework application helpers
 *
 * Set of useful functions for app development
 *
 * @package Kawa
 */

use Kawa\Support\Helper;

use function Env\env;

/**
 * -------------------------------------------------------------------------
 * Environment
 * -------------------------------------------------------------------------
 */
if (!function_exists('is_environment')) {

	/**
	 * Define does current environment is same as provided
	 *
	 * @param string $env
	 * @return boolean
	 */
	function is_environment(string $env) : bool
	{
		return env('WP_ENV') === $env;
	}
}

if (!function_exists('is_development')) {

	/**
	 * Define does current environment is `development`
	 *
	 * @return boolean
	 */
	function is_development() : bool
	{
		return is_environment('development');
	}
}

if (!function_exists('is_production')) {

	/**
	 * Define does current environment is `production`
	 *
	 * @return boolean
	 */
	function is_production() : bool
	{
		return is_environment('production');
	}
}

if (!function_exists('is_staging')) {

	/**
	 * Define does current environment is `staging`
	 *
	 * @return boolean
	 */
	function is_staging() : bool
	{
		return is_environment('staging');
	}
}

/**
 * -------------------------------------------------------------------------
 * App
 * -------------------------------------------------------------------------
 */
if (!function_exists('dd')) {

	/**
	 * Dump and die helper
	 *
	 * `dump()` comes with Tracy debugger
	 *
	 * @param mixed $var
	 * @return void
	 */
	function dd(mixed $var) : void
	{
		dump($var);
		exit(1);
	}
}

if (!function_exists('app')) {

	/**
	 * Get container instance or binded value if passed
	 *
	 * @param string|null $key
	 * @return mixed
	 */
	function app(?string $key = null) : mixed
	{
		return Helper::app($key);
	}
}

/**
 * -------------------------------------------------------------------------
 * Response
 * -------------------------------------------------------------------------
 */
if (!function_exists('view')) {


	function view(string $template, array $context = [])
	{
		return Helper::viewResponse($template, $context);
	}
}
