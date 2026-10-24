<?php
/**
 * Project list shared by the Projects archive and the project-type / service filters.
 *
 * Expects the main query to hold projects. Pass $args['title'], $args['highlight'], $args['intro'].
 *
 * @package suburbancm
 */

$args         = $args ?? [];
$current      = get_queried_object();
$current_id   = ( $current instanceof WP_Term ) ? $current->term_id : 0;
$filter_terms = get_terms( [ 'taxonomy' => 'project_type', 'hide_empty' => true ] );
?>

<main id="site-content" class="scm-projects-list scm-bg-ink">
	<?php
	suburbancm_page_header(
		[
			'title'          => $args['title'] ?? __( 'Projects.', 'suburbancm' ),
			'titleHighlight' => $args['highlight'] ?? '',
			'subtitle'       => $args['intro'] ?? '',
		]
	);
	?>
	<div class="scm-wrap">
		<?php if ( $filter_terms && ! is_wp_error( $filter_terms ) && count( $filter_terms ) > 1 ) : ?>
			<nav class="scm-filters" aria-label="<?php esc_attr_e( 'Filter projects by type', 'suburbancm' ); ?>">
				<a class="scm-chip<?php echo $current_id ? '' : ' is-active'; ?>" href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>"<?php echo $current_id ? '' : ' aria-current="page"'; ?>><?php esc_html_e( 'All projects', 'suburbancm' ); ?></a>
				<?php foreach ( $filter_terms as $term ) : ?>
					<?php $active = $term->term_id === $current_id; ?>
					<a class="scm-chip<?php echo $active ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_term_link( $term ) ); ?>"<?php echo $active ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $term->name ); ?></a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<h2 class="screen-reader-text"><?php esc_html_e( 'Project list', 'suburbancm' ); ?></h2>
			<div class="scm-card-grid">
				<?php
				$i = 0;
				while ( have_posts() ) :
					the_post();
					suburbancm_project_card( get_the_ID(), ( 0 === $i && ! is_paged() ) ? 'feature' : 'card' );
					$i++;
				endwhile;
				?>
			</div>
			<?php
			the_posts_pagination(
				[
					'mid_size'           => 1,
					'prev_text'          => __( '← Newer', 'suburbancm' ),
					'next_text'          => __( 'Older →', 'suburbancm' ),
					'screen_reader_text' => __( 'Projects navigation', 'suburbancm' ),
					'class'              => 'scm-pagination',
				]
			);
			?>
		<?php else : ?>
			<div class="scm-empty">
				<p class="scm-d scm-h-s"><?php esc_html_e( 'No projects here yet.', 'suburbancm' ); ?></p>
				<a class="scm-link" href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>"><?php esc_html_e( 'See all projects →', 'suburbancm' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</main>
