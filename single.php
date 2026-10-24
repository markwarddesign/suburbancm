<?php
/**
 * Single news post: title area, photo, the story on a light band, then the next post.
 *
 * @package suburbancm
 */

get_header();

while ( have_posts() ) :
	the_post();
	$post_id  = get_the_ID();
	$category = suburbancm_first_term( $post_id, 'category' );
	$news_url = get_option( 'page_for_posts' ) ? get_permalink( (int) get_option( 'page_for_posts' ) ) : home_url( '/' );
	$older    = get_previous_post();
	$newer    = get_next_post();
	$next     = $older ?: $newer;
	?>
	<main id="site-content" class="scm-single-post">
		<header class="scm-wrap scm-project-head scm-post-head">
			<a class="scm-back" href="<?php echo esc_url( $news_url ); ?>"><?php esc_html_e( '← All news', 'suburbancm' ); ?></a>
			<?php if ( $category && 'Uncategorized' !== $category ) : ?>
				<p class="scm-eyebrow scm-gold"><?php echo esc_html( $category ); ?></p>
			<?php endif; ?>
			<h1 class="scm-d scm-h-l"><?php the_title(); ?></h1>
			<?php if ( has_excerpt() ) : ?>
				<p class="scm-lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>
			<p class="scm-post-meta">
				<?php if ( get_the_author() ) : ?>
					<?php
					/* translators: %s: author name */
					printf( esc_html__( 'By %s', 'suburbancm' ), esc_html( get_the_author() ) );
					?>
					<span aria-hidden="true">·</span>
				<?php endif; ?>
				<?php echo esc_html( suburbancm_post_meta_line( $post_id ) ); ?>
			</p>
		</header>

		<?php if ( has_post_thumbnail() ) : ?>
			<figure class="scm-photo-band scm-photo-band--tall">
				<?php echo get_the_post_thumbnail( $post_id, 'full', [ 'alt' => suburbancm_image_alt( get_post_thumbnail_id( $post_id ), get_the_title( $post_id ) ), 'sizes' => '100vw', 'fetchpriority' => 'high', 'loading' => 'eager' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			</figure>
		<?php endif; ?>

		<article class="scm-prose scm-post-body">
			<?php the_content(); ?>
		</article>

		<?php if ( $next ) : ?>
			<a class="scm-next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
				<span class="scm-next__text">
					<span class="scm-eyebrow"><?php echo $older ? esc_html__( 'Previous post', 'suburbancm' ) : esc_html__( 'Next post', 'suburbancm' ); ?></span>
					<span class="scm-d scm-next__title"><?php echo esc_html( get_the_title( $next ) ); ?> →</span>
				</span>
				<span class="scm-next__pic">
					<?php echo get_the_post_thumbnail( $next, 'large', [ 'alt' => '', 'loading' => 'lazy' ] ); ?>
				</span>
			</a>
		<?php endif; ?>
	</main>
	<?php
endwhile;

get_footer();
