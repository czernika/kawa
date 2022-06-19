<?php
/**
 * App web routes
 *
 * List of all WordPress conditionals can be found here:
 * @link https://codex.wordpress.org/Conditional_Tags
 */

use Kawa\Support\Facades\Route;

Route::isFrontPage('FrontPageController@index');
