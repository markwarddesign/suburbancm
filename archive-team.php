<?php
/**
 * Team list.
 *
 * @package suburbancm
 */

get_header();
?>
<main id="site-content" class="scm-team-list scm-bg-ink">
	<?php
	suburbancm_page_header(
		[
			'title'          => __( 'The people', 'suburbancm' ),
			'titleHighlight' => __( 'behind the build.', 'suburbancm' ),
			'subtitle'       => __( 'Experienced, local and on site. Meet the team that will run your project.', 'suburbancm' ),
		]
	);
	?>
	<div class="scm-wrap">
		<?php if ( have_posts() ) : ?>
			<div class="scm-people">
				<?php
				while ( have_posts() ) :
					the_post();
					$role = suburbancm_field( 'role' );
					?>
					<a class="scm-person" href="<?php the_permalink(); ?>">
						<span class="scm-person__photo">
							<?php
							if ( has_post_thumbnail() ) {
								the_post_thumbnail( 'large', [ 'alt' => '', 'loading' => 'lazy' ] );
							}
							?>
						</span>
						<span class="scm-person__text">
							<?php if ( $role ) : ?>
								<span class="scm-eyebrow scm-gold"><?php echo esc_html( $role ); ?></span>
							<?php endif; ?>
							<span class="scm-d scm-person__name"><?php the_title(); ?></span>
							<span class="scm-person__more"><?php esc_html_e( 'View profile →', 'suburbancm' ); ?></span>
						</span>
					</a>
				<?php endwhile; ?>
			</div>
		<?php else : ?>
			<div class="scm-empty"><p class="scm-d scm-h-s"><?php esc_html_e( 'Team profiles are on their way.', 'suburbancm' ); ?></p></div>
		<?php endif; ?>
	</div>
</main>
<?php
get_footer();
