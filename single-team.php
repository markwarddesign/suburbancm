<?php
/**
 * Team member profile: photo beside role, name and summary; bio below; related projects.
 *
 * @package suburbancm
 */

get_header();

while ( have_posts() ) :
	the_post();
	$post_id    = get_the_ID();
	$role       = suburbancm_field( 'role', $post_id );
	$linkedin   = suburbancm_field( 'linkedin', $post_id );
	$skills     = suburbancm_field( 'skills', $post_id );
	$note       = suburbancm_field( 'personal_note', $post_id );
	$related    = (array) suburbancm_field( 'related_projects', $post_id );
	$first_name = strtok( get_the_title(), ' ' );
	$skills     = is_array( $skills ) ? $skills : preg_split( '/[,\n]+/', (string) $skills );
	// The ACF repeater gives rows of [ 'skill' => '…' ]; plain meta gives strings.
	$skills     = array_filter( array_map( static fn( $s ) => trim( (string) ( is_array( $s ) ? ( $s['skill'] ?? reset( $s ) ) : $s ) ), $skills ) );
	$related    = array_filter( array_map( static fn( $p ) => is_object( $p ) ? $p->ID : (int) $p, $related ) );
	?>
	<main id="site-content" class="scm-profile">
		<section class="scm-wrap scm-profile__head">
			<a class="scm-back" href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><?php esc_html_e( '← About SuburbanCM', 'suburbancm' ); ?></a>
			<div class="scm-member">
				<div class="scm-member__photo">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'large', [ 'alt' => get_the_title() ] );
					}
					?>
				</div>
				<div class="scm-member__text">
					<?php if ( $role ) : ?>
						<p class="scm-eyebrow scm-gold"><?php echo esc_html( $role ); ?></p>
					<?php endif; ?>
					<h1 class="scm-d scm-h-xl"><?php the_title(); ?>.</h1>
					<?php if ( has_excerpt() ) : ?>
						<p class="scm-lede"><?php echo esc_html( get_the_excerpt() ); ?></p>
					<?php endif; ?>
					<?php if ( $skills ) : ?>
						<ul class="scm-tags">
							<?php foreach ( $skills as $skill ) : ?>
								<li><?php echo esc_html( $skill ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
					<div class="scm-btns">
						<a class="scm-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Schedule a consultation', 'suburbancm' ); ?></a>
						<?php if ( $linkedin ) : ?>
							<a class="scm-btn scm-btn--line" href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'LinkedIn ↗', 'suburbancm' ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>

		<?php if ( '' !== trim( wp_strip_all_tags( get_the_content() ) ) ) : ?>
			<section class="scm-profile__bio scm-bg-bone">
				<div class="scm-wrap scm-section scm-profile__bio-inner">
					<h2 class="scm-d scm-h-l">
						<?php
						/* translators: %s: first name */
						printf( esc_html__( 'About %s.', 'suburbancm' ), esc_html( $first_name ) );
						?>
					</h2>
					<div class="scm-entry scm-entry--bone scm-profile__content"><?php the_content(); ?></div>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $note ) : ?>
			<section class="scm-bg-ink-2">
				<div class="scm-wrap scm-section--sm scm-profile__note">
					<p class="scm-eyebrow scm-gold"><?php esc_html_e( 'Off the job', 'suburbancm' ); ?></p>
					<p><?php echo wp_kses_post( $note ); ?></p>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $related ) : ?>
			<section class="scm-bg-ink">
				<div class="scm-wrap scm-section">
					<h2 class="scm-d scm-h-l scm-profile__related-title">
						<?php
						/* translators: %s: first name */
						printf( esc_html__( "Projects %s has led.", 'suburbancm' ), esc_html( $first_name ) );
						?>
					</h2>
					<div class="scm-card-grid">
						<?php foreach ( $related as $project_id ) : ?>
							<?php suburbancm_project_card( $project_id ); ?>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</main>
	<?php
endwhile;

get_footer();
