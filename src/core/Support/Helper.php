<?php
/**
 * Helper class
 *
 * Contains list of useful methods for web-development
 */

declare(strict_types=1);

namespace Kawa\Support;

use Kawa\App\App;
use Kawa\App\Config;
use Kawa\App\Exceptions\HttpException;
use Kawa\Foundation\RedirectResponse;
use Kawa\Foundation\Response;
use Kawa\Foundation\ResponseInterface;
use Kawa\Routing\Exceptions\NamedRouteException;
use Kawa\Routing\Router;
use Kawa\Routing\UriRoute;
use Kawa\View\ViewFactory;

class Helper
{

	/** @var App */
	private static App $app;

	/**
	 * Instantiate helper class
	 *
	 * @param App $app
	 * @return void
	 */
	public static function instantiate(App $app) : void
	{
		self::$app = $app;
	}

	/**
	 * Get container instance or binded value if passed
	 *
	 * @param string|null $key
	 * @return mixed
	 */
	public static function app(?string $key) : mixed
	{
		if ($key) {
			return self::$app->get($key);
		}

		return self::$app;
	}

	/**
	 * Throw exception
	 *
	 * @param integer $code
	 * @param string $message
	 * @throws HttpException
	 * @return never
	 */
	public static function abort(int $code, string $message = '')
	{
		$message = $message === '' ?
					Response::$statusTexts[$code] :
					$message;

		throw new HttpException($message, $code);
	}

	/**
	 * Render view response
	 *
	 * @param string $template
	 * @param array $context
	 * @param mixed ...$params
	 * @return ResponseInterface
	 */
	public static function viewResponse(string $template, array $context = [], ...$params) : ResponseInterface
	{
		/** @var ViewFactory */
		$factory = self::$app->get(ViewFactory::class);

		return $factory->render($template, $context, ...$params);
	}

	/**
	 * Get redirect response
	 *
	 * @param string $to
	 * @param int $status
	 * @param array $headers
	 * @return ResponseInterface
	 */
	public static function redirectResponse(string $to, int $status = Response::HTTP_FOUND, array $headers = []) : ResponseInterface
	{
		return new RedirectResponse($to, $status, $headers);
	}

	/**
	 * Get value from config files
	 *
	 * @param string $key
	 * @param mixed $default
	 * @return mixed
	 */
	public static function config(string $key, $default = null) : mixed
	{
		return Config::get($key, $default);
	}

	/**
	 * Get route by its name
	 *
	 * @param string $name
	 * @throws NamedRouteException
	 * @return UriRoute
	 */
	public static function route(string $name) : UriRoute
	{
		$routes = self::getRouter()->getNamedRoutes();

		if (!array_key_exists($name, $routes)) {
			throw new NamedRouteException(sprintf('Route named %s doesn\'t found', $name));
		}

		return $routes[$name];
	}

	/**
	 * Get route by its name
	 *
	 * @param string $name
	 * @throws NamedRouteException
	 * @return string
	 */
	public static function routeUri(string $name) : string
	{
		return self::route($name)->getUri();
	}

	/**
	 * Get router instance
	 *
	 * @return Router
	 */
	public static function getRouter() : Router
	{
		return self::$app->get('router');
	}
}
