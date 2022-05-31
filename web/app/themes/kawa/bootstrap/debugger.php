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
// Debugger::$productionMode = is_production();

Debugger::enable();
