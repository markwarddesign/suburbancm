<?php
/**
 * Projects archive.
 *
 * @package suburbancm
 */

get_header();

get_template_part(
	'template-parts/projects-list',
	null,
	[
		'title' => __( 'Projects.', 'suburbancm' ),
		'intro' => __( 'City parks, municipal improvements, state facilities and private development across Southern Idaho.', 'suburbancm' ),
	]
);

get_footer();
