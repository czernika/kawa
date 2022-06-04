<?php
/**
 * Helper class
 *
 * Contains list of useful methods for web-development
 */

declare(strict_types=1);

namespace Kawa\Support;

use Kawa\App\App;
use Kawa\App\Exceptions\HttpException;
use Kawa\Foundation\Response;
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
	 * @return Response
	 */
	public static function viewResponse(string $template, array $context = [], ...$params) : Response
	{
		/** @var ViewFactory */
		$factory = self::$app->get(ViewFactory::class);

		return $factory->render($template, $context, ...$params);
	}
}
