<?php
/**
 * Kawa Framework application helpers
 *
 * Set of useful functions for app development
 *
 * @package Kawa
 */

use Kawa\Foundation\Response;
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
	 * `dumpe()` alias which comes with Tracy debugger
	 *
	 * @param mixed $var
	 * @return void
	 */
	function dd(mixed $var) : void
	{
		dumpe($var);
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

if (!function_exists('config')) {

	/**
	 * Get value from config files
	 *
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	function config(string $key, $default = null) : mixed
	{
		return Helper::config($key, $default);
	}
}

/**
 * -------------------------------------------------------------------------
 * Response
 * -------------------------------------------------------------------------
 */
if (!function_exists('view')) {

	/**
	 * Convert template into response instance
	 *
	 * @param string $template
	 * @param array $context
	 * @param mixed ...$params
	 * @return Response
	 */
	function view(string $template, array $context = [], ...$params) : Response
	{
		return Helper::viewResponse($template, $context, ...$params);
	}
}

if (!function_exists('abort')) {

	/**
	 * Throw exception
	 *
	 * @param integer $code
	 * @param string $message
	 * @throws HttpException
	 * @return never
	 */
	function abort(int $code, string $message = '')
	{
		return Helper::abort($code, $message);
	}
}

if (!function_exists('abort_if')) {

	/**
	 * Throw exception if condition was met
	 *
	 * @param bool $condition
	 * @param integer $code
	 * @param string $message
	 * @throws HttpException
	 * @return never
	 */
	function abort_if(bool $condition, int $code, string $message = '')
	{
		if ($condition) {
			return Helper::abort($code, $message);
		}
	}
}
