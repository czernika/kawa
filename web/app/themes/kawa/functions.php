<?php
/**
 * Kawa Framework - developer-friendly framework for WordPress theme development with latte template engine and bedrock structure
 *
 * @package Kawa
 * @author Ihar Aliakseyenka <aliha.devs@gmail.com>
 * @license MIT
 */

/**
 * -------------------------------------------------------------------------
 * Define app debugger
 * -------------------------------------------------------------------------
 *
 * This file is required for Tracy debugger. Include it first
 * as we want to catch any errors (core included)
 */
require_once __DIR__ . '/bootstrap/debugger.php';

/**
 * -------------------------------------------------------------------------
 * Boot application
 * -------------------------------------------------------------------------
 *
 * Include bootstrappers
 */
require_once __DIR__ . '/bootstrap/app.php';

/**
 * ==========================================================================
 * Stop line - you may place your code AFTER this block
 * ==========================================================================
 *
 * All you custom functions may be placed here as it is still WordPress installation.
 *
 * ! But Kawa Framework recommends you NOT to do that
 * and handle logic inside theme source directories.
 *
 * Happy coding!
 */
