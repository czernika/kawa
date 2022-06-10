<?php
/**
 * Fake WordPress core functions
 */

function is_front_page() : bool
{
	return true;
}

function is_page($id) : bool
{
	return true;
}

function get_template_directory() : string
{
	return __DIR__;
}
