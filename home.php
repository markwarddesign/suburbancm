<?php
/**
 * News: the posts page (Settings › Reading › Posts page).
 *
 * @package suburbancm
 */

get_header();

get_template_part(
	'template-parts/posts-list',
	null,
	[
		'intro' => __( 'Project stories, company news and plain-English guides to building in Twin Falls and the Magic Valley.', 'suburbancm' ),
	]
);

get_footer();
