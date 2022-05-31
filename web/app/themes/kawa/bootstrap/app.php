<?php
/**
 * Boot application
 *
 * We will bind some crucial values into DI Container
 * and boot application itself
 */

use DI\Container;
use Kawa\App\App;

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
 */
$app = new App($container);

/**
 * -------------------------------------------------------------------------
 * Run Forest Run!
 * -------------------------------------------------------------------------
 *
 * Finally boot application itself on init hook
 */
add_action('init', [$app, 'boot']);
