<?php
/**
 * Single bid opportunity: title and due date with the submit button, the bid details and documents,
 * then a gold band repeating the deadline and submit button.
 *
 * @package suburbancm
 */

get_header();

while ( have_posts() ) :
	the_post();
	$post_id  = get_the_ID();
	$due      = suburbancm_field( 'due_date', $post_id );
	$submit   = suburbancm_bid_submit( $post_id );
	$extra    = [
		'text' => get_post_meta( $post_id, '_wp_bidding_cta_text', true ),
		'url'  => get_post_meta( $post_id, '_wp_bidding_cta_url', true ),
	];
	$is_past  = $due && strtotime( $due . ' 23:59:59' ) < time();
	$target   = $submit['external'] ? ' target="_blank" rel="noopener"' : '';
	$type     = suburbancm_first_term( $post_id, 'bidding_type' );

	// This page ends in its own submit band.
	add_filter( 'suburbancm_footer_cta', '__return_false' );
	?>
	<main id="site-content" class="scm-bid-page">
		<header class="scm-wrap scm-project-head">
			<a class="scm-back" href="<?php echo esc_url( get_post_type_archive_link( 'bidding' ) ); ?>"><?php esc_html_e( '← All bid opportunities', 'suburbancm' ); ?></a>
			<p class="scm-eyebrow scm-gold"><?php echo esc_html( $type ?: __( 'Invitation to bid', 'suburbancm' ) ); ?></p>
			<h1 class="scm-d scm-h-xl"><?php the_title(); ?></h1>
			<div class="scm-bid-page__row">
				<?php if ( $due ) : ?>
					<p class="scm-due<?php echo $is_past ? ' is-past' : ''; ?>">
						<span class="scm-due__label"><?php echo $is_past ? esc_html__( 'Bids closed', 'suburbancm' ) : esc_html__( 'Bids due', 'suburbancm' ); ?></span>
						<span class="scm-d scm-due__date"><?php echo esc_html( suburbancm_date( $due, 'F j, Y' ) ); ?></span>
					</p>
				<?php endif; ?>
				<?php if ( ! $is_past ) : ?>
					<div class="scm-btns">
						<a class="scm-btn" href="<?php echo esc_url( $submit['url'] ); ?>"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php esc_html_e( 'Submit a bid', 'suburbancm' ); ?></a>
						<?php if ( $extra['text'] && $extra['url'] ) : ?>
							<a class="scm-btn scm-btn--line" href="<?php echo esc_url( $extra['url'] ); ?>" target="_blank" rel="noopener"><?php echo esc_html( $extra['text'] ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>
			</div>
			<p class="scm-bid-page__dates">
				<?php
				printf(
					/* translators: 1: published date, 2: updated date */
					esc_html__( 'Posted %1$s · Updated %2$s', 'suburbancm' ),
					esc_html( get_the_date( 'M j, Y' ) ),
					esc_html( get_the_modified_date( 'M j, Y' ) )
				);
				?>
			</p>
		</header>

		<div class="scm-entry scm-entry--bone scm-bid-page__content">
			<?php the_content(); ?>
		</div>

		<?php if ( ! $is_past ) : ?>
			<section class="scm-cta scm-bg-gold">
				<div class="scm-wrap scm-section--sm scm-cta__inner">
					<div class="scm-cta__text">
						<h2 class="scm-d scm-h-l"><?php esc_html_e( 'Ready to bid?', 'suburbancm' ); ?></h2>
						<?php if ( $due ) : ?>
							<p class="scm-lede">
								<?php
								/* translators: %s: due date */
								printf( esc_html__( 'Bids are due %s. Questions before then? Our estimating team is glad to help.', 'suburbancm' ), esc_html( suburbancm_date( $due, 'F j, Y' ) ) );
								?>
							</p>
						<?php endif; ?>
					</div>
					<div class="scm-btns">
						<a class="scm-btn scm-btn--line" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Ask a question', 'suburbancm' ); ?></a>
						<a class="scm-btn scm-btn--ink" href="<?php echo esc_url( $submit['url'] ); ?>"<?php echo $target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php esc_html_e( 'Submit a bid →', 'suburbancm' ); ?></a>
					</div>
				</div>
			</section>
		<?php endif; ?>
	</main>
	<?php
endwhile;

get_footer();
