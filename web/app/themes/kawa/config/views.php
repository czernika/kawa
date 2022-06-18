<?php

return [

	/**
	 * -------------------------------------------------------------------------
	 * Views directory
	 * -------------------------------------------------------------------------
	 *
	 * Where all view files are listed. Should be relative path from theme directory
	 */
	'views' => 'resources/views',

	/**
	 * -------------------------------------------------------------------------
	 * List of default template files
	 * -------------------------------------------------------------------------
	 *
	 * This view files will be rendered
	 */
	'templates' => [
		'error' => 'errors.index',
	],

	/**
	 * -------------------------------------------------------------------------
	 * Default query parameters
	 * -------------------------------------------------------------------------
	 *
	 * Applies for every query request
	 */
	'query' => [

		/**
		 * When fetching all records it may be useful to set limit
		 *
		 * Default: `-1` (fetch all)
		 */
		'limit' => -1,
	],
];
