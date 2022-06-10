<?php
/**
 * Set debugger properties
 *
 * @link https://tracy.nette.org/en/guide
 */

use Tracy\Debugger;

/**
 * -------------------------------------------------------------------------
 * Set production mode manually
 * -------------------------------------------------------------------------
 *
 * The system detects a server by IP address. The production mode is chosen if an application is accessed via a public IP address. A local IP address leads to development mode. It is not necessary to set the mode in most cases.
 * The mode is correctly recognized when you are launching the application on your local server or in production.
 */
Debugger::$productionMode = is_production();

/**
 * -------------------------------------------------------------------------
 * Set dark theme
 * -------------------------------------------------------------------------
 *
 * Text became more readable :)
 */
Debugger::$dumpTheme = 'dark';

/**
 * -------------------------------------------------------------------------
 * Production error template page
 * -------------------------------------------------------------------------
 *
 * Path to the template which will handle unexpected error output in a production mode
 */
Debugger::$errorTemplate = WP_CONTENT_DIR . '/php-error.php';

/**
 * -------------------------------------------------------------------------
 * Show Tracy bar or not
 * -------------------------------------------------------------------------
 *
 * Littler helper in a right corner
 * Note you may use `bdump()` helper method, which outputs debug data into this bar
 */
Debugger::$showBar = true;

/**
 * -------------------------------------------------------------------------
 * Enable debugger
 * -------------------------------------------------------------------------
 */
Debugger::enable();
