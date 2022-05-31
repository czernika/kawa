<?php
/**
 * Main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 *
 * ! Do not remove this file
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 * @package Kawa
 */

use Kawa\Foundation\Request;

$request = Request::createFromGlobals();

do_action('kawa/response', $request);
