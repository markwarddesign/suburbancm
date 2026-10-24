<?php
/**
 * Post list shared by the News page and the category / tag archives.
 *
 * Expects the main query to hold posts. Pass $args['title'], $args['highlight'], $args['intro'].
 *
 * @package suburbancm
 */

$args       = $args ?? [];
$current    = get_queried_object();
$current_id = ( $current instanceof WP_Term ) ? $current->term_id : 0;
$categories = get_categories( [ 'hide_empty' => true, 'exclude' => [ (int) get_option( 'default_category' ) ] ] );
$news_url   = get_option( 'page_for_posts' ) ? get_permalink( (int) get_option( 'page_for_posts' ) ) : home_url( '/' );
?>

<main id="site-content" class="scm-posts-list scm-bg-ink">
	<?php
	suburbancm_page_header(
		[
			'title'          => $args['title'] ?? __( 'News &', 'suburbancm' ),
			'titleHighlight' => $args['highlight'] ?? __( 'field notes.', 'suburbancm' ),
			'subtitle'       => $args['intro'] ?? '',
		]
	);
	?>
	<div class="scm-wrap">
		<?php if ( count( $categories ) > 1 ) : ?>
			<nav class="scm-filters" aria-label="<?php esc_attr_e( 'Filter news by topic', 'suburbancm' ); ?>">
				<a class="scm-chip<?php echo $current_id ? '' : ' is-active'; ?>" href="<?php echo esc_url( $news_url ); ?>"<?php echo $current_id ? '' : ' aria-current="page"'; ?>><?php esc_html_e( 'All news', 'suburbancm' ); ?></a>
				<?php foreach ( $categories as $category ) : ?>
					<?php $active = $category->term_id === $current_id; ?>
					<a class="scm-chip<?php echo $active ? ' is-active' : ''; ?>" href="<?php echo esc_url( get_category_link( $category ) ); ?>"<?php echo $active ? ' aria-current="page"' : ''; ?>><?php echo esc_html( $category->name ); ?></a>
				<?php endforeach; ?>
			</nav>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<h2 class="screen-reader-text"><?php esc_html_e( 'Posts', 'suburbancm' ); ?></h2>
			<div class="scm-card-grid">
				<?php
				$i = 0;
				while ( have_posts() ) :
					the_post();
					suburbancm_post_card( get_the_ID(), ( 0 === $i && ! is_paged() ) ? 'feature' : 'card' );
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
					'screen_reader_text' => __( 'News navigation', 'suburbancm' ),
					'class'              => 'scm-pagination',
				]
			);
			?>
		<?php else : ?>
			<div class="scm-empty">
				<div class="scm-empty__text">
					<h2 class="scm-d scm-h-m"><?php esc_html_e( 'Nothing posted here yet.', 'suburbancm' ); ?></h2>
					<p><?php esc_html_e( 'Project stories and company news will show up here as we publish them.', 'suburbancm' ); ?></p>
				</div>
				<a class="scm-btn" href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>"><?php esc_html_e( 'See our projects', 'suburbancm' ); ?></a>
			</div>
		<?php endif; ?>
	</div>
</main>
