<?php
/**
 * Application Kernel
 *
 * Converts upcoming request into appropriate response
 */

declare(strict_types=1);

namespace Kawa\Foundation;

use Closure;
use DI\Container;
use Kawa\App\Exceptions\HttpException;
use Kawa\Routing\Exceptions\RouteNotFoundException;
use Kawa\Routing\Route;
use Kawa\Routing\Router;
use Kawa\View\ResponseService;
use Kawa\View\ViewFactory;
use Throwable;

abstract class Kernel implements KernelInterface
{

	/**
	 * List of theme service providers
	 *
	 * @var array
	 */
	protected array $providers = [];

	/**
	 * List of theme middleware
	 *
	 * @var array
	 */
	protected array $middleware = [];

	/** @var ResponseService */
	protected ResponseService $responseService;

	public function __construct(
		protected Container $container,
		protected Router $router,
	) {}

	/**
	 * @inheritDoc
	 */
	public function handle(Request $request) : void
	{
		$resolver = $this->routes();
		$resolver($this->router);

		try {
			$route = $this->getSatisfiedRoute($request);
			$response = $this->dispatch($route, $request);
		} catch (RouteNotFoundException $e) {
			// Handle 404 or middleware exceptions
		}

		if (!headers_sent()) {
			$response->sendHeaders();
		}

		echo $response->getContent();
	}

	/**
	 * Dispatch route and return Response instance
	 *
	 * @param Route $route
	 * @param Request $request
	 * @return Response
	 */
	protected function dispatch(Route $route, Request $request) : Response
	{
		$handler = $route->getHandler();
		$middleware = $route->getMiddleware();

		try {
			$response = $this->executeMiddleware($middleware, $request, $handler);
		} catch (HttpException $th) {
			$response = $this->throwExceptionPage($th);
		}

		if (is_string($response)) {
			return new Response($response);
		}

		return $response;
	}

	/**
	 * Handle exception
	 *
	 * TODO refactor template
	 * @param Throwable $th
	 * @return mixed
	 */
	protected function throwExceptionPage(Throwable $th) : mixed
	{
		return $this->container->call(
			[ViewFactory::class, 'render'],
			[
				'template' => config('views.templates.error', 'errors.index'),
				'context' => ['message' => $th->getMessage(), 'code' => $th->getCode()],
			],
		);
	}

	/**
	 * Execute middleware and get response
	 *
	 * @param array $middleware
	 * @param Request $request
	 * @param Closure|array|string $next
	 * @throws InvalidArgumentException if wrong middleware key was given
	 * @return ResponseInterface|string
	 */
	protected function executeMiddleware(array $middleware, Request $request, Closure|array|string $next) : Response|string
	{
		$topMiddleware = array_shift($middleware);

		if ($topMiddleware === null) {
			$params = [$request];
			return $this->container->call($next, $params);
		}

		$nextMiddleware = function ($request) use ($middleware, $next) {
			return $this->executeMiddleware($middleware, $request, $next);
		};

		$middlewareGroup = $this->getMiddleware($topMiddleware);

		if (is_array($middlewareGroup)) {
			return $this->executeMiddleware($middlewareGroup, $request, $nextMiddleware);
		}

		$middlewareHandler = $this->container->make($middlewareGroup);

		$arguments = [$request, $nextMiddleware];

		return $this->container->call([$middlewareHandler, 'handle'], $arguments);
	}

	/**
	 * Get middleware by key
	 *
	 * @param string $key
	 * @return void
	 */
	public function getMiddleware(string $key)
	{
		if (array_key_exists($key, $this->middleware)) {
			return $this->middleware[$key];
		}

		return $key;
	}

	/**
	 * @inheritDoc
	 */
	public function getProviders() : array
	{
		return $this->providers;
	}

	/**
	 * Get satisfied route according to request
	 *
	 * @param Request $request
	 * @throws RouteNotFoundException no route was satisfied
	 * @return Route
	 */
	public function getSatisfiedRoute(Request $request) : Route
	{
		$routes = $this->router->routes($request->getMethod());
		foreach ($routes as $route) {
			if ($route->isSatisfied()) {
				return $route;
			}
		}

		throw new RouteNotFoundException();
	}

	/**
	 * Resolve web routes
	 *
	 * @return Closure
	 */
	abstract protected function routes() : Closure;
}
