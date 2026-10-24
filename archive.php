<?php
/**
 * Category, tag and date archives for news posts.
 *
 * @package suburbancm
 */

get_header();

$term = get_queried_object();
get_template_part(
	'template-parts/posts-list',
	null,
	[
		'title'     => ( is_category() || is_tag() ) ? single_term_title( '', false ) : wp_strip_all_tags( get_the_archive_title() ),
		'highlight' => '',
		'intro'     => $term instanceof WP_Term && $term->description ? $term->description : '',
	]
);

get_footer();
