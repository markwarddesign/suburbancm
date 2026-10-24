<?php
/**
 * Projects filtered by the service provided.
 *
 * @package suburbancm
 */

get_header();

$term = get_queried_object();
get_template_part(
	'template-parts/projects-list',
	null,
	[
		'title'     => single_term_title( '', false ),
		'highlight' => __( 'projects.', 'suburbancm' ),
		'intro'     => $term instanceof WP_Term && $term->description ? $term->description : '',
	]
);

get_footer();
