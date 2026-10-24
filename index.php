<?php
/**
 * Last-resort template (search results and anything without its own template): the news list.
 *
 * @package suburbancm
 */

get_header();

get_template_part(
	'template-parts/posts-list',
	null,
	is_search()
		? [
			/* translators: %s: search query */
			'title'     => sprintf( __( 'Results for “%s”', 'suburbancm' ), get_search_query() ),
			'highlight' => '',
		]
		: []
);

get_footer();
