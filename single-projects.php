<?php
/**
 * Single project: title area, then the content (the Project Page block draws the photo,
 * facts bar and overview; galleries and other blocks follow), then the next project.
 *
 * @package suburbancm
 */

get_header();

while ( have_posts() ) :
	the_post();
	$post_id  = get_the_ID();
	$info     = suburbancm_project_info( $post_id );
	$type     = suburbancm_first_term( $post_id, 'project_type' );
	$subtitle = $info['subtitle'] ?: wp_trim_words( wp_strip_all_tags( (string) $info['summary'] ), 32 );
	$next     = suburbancm_next_project( $post_id );
	?>
	<main id="site-content" class="scm-single-project">
		<header class="scm-wrap scm-project-head">
			<a class="scm-back" href="<?php echo esc_url( get_post_type_archive_link( 'projects' ) ); ?>"><?php esc_html_e( '← All projects', 'suburbancm' ); ?></a>
			<?php if ( $type ) : ?>
				<p class="scm-eyebrow scm-gold"><?php echo esc_html( $type ); ?></p>
			<?php endif; ?>
			<h1 class="scm-d scm-h-xl"><?php the_title(); ?></h1>
			<?php if ( $subtitle ) : ?>
				<p class="scm-lede"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>
		</header>

		<div class="scm-entry">
			<?php
			if ( has_block( 'suburbancm/project-page' ) ) {
				the_content();
			} else {
				// Projects written without the Project Page block still get the photo, facts and overview.
				if ( has_post_thumbnail() ) {
					echo '<figure class="scm-photo-band scm-photo-band--tall">' . get_the_post_thumbnail( $post_id, 'full', [ 'alt' => '', 'sizes' => '100vw' ] ) . '</figure>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				}
				suburbancm_project_spec( $info );
				the_content();
			}
			?>
		</div>

		<?php if ( $next ) : ?>
			<a class="scm-next" href="<?php echo esc_url( get_permalink( $next ) ); ?>">
				<span class="scm-next__text">
					<span class="scm-eyebrow"><?php esc_html_e( 'Next project', 'suburbancm' ); ?></span>
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
