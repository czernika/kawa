<?php
/**
 * Boot application
 *
 * We will bind some crucial values into DI Container
 * and boot application itself
 */

use DI\Container;
use Kawa\App\App;
use Kawa\Foundation\KernelInterface;
use Kawa\Foundation\Request;
use Kawa\Routing\Router;
use Theme\Http\Kernel;

/**
 * -------------------------------------------------------------------------
 * Create application container
 * -------------------------------------------------------------------------
 *
 * You may pass here any crucial definitions for your theme
 * or simply create development container
 */
$container = new Container();

/**
 * -------------------------------------------------------------------------
 * Create application main instance
 * -------------------------------------------------------------------------
 *
 * This will instantiate app service container
 *
 * Also we need to define crucial services
 */
$app = new App($container);

/**
 * -------------------------------------------------------------------------
 * Choose template engine to work with
 * -------------------------------------------------------------------------
 *
 * You may use native WordPress request-response lifecycle,
 * or use one of these supported template engine - "latte", "blade" or "twig"
 *
 * Default: "latte"
 */
$app->engine(\Kawa\View\Engines\Latte::class);

/**
 * -------------------------------------------------------------------------
 * Bind some values into container
 * -------------------------------------------------------------------------
 *
 * This bindings should be resolved early
 */
$app->factory(
	Request::class,
	[Request::class, 'createFromGlobals'],
);

$app->singleton(
	KernelInterface::class,
	\DI\create(Kernel::class)
		->constructor($container, \DI\get(Router::class))
);

/**
 * -------------------------------------------------------------------------
 * Run Forest Run!
 * -------------------------------------------------------------------------
 *
 * Finally boot application itself on init hook
 */
add_action('init', [$app, 'boot']);
