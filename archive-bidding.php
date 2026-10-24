<?php
/**
 * Bid opportunities: open bids (due today or later), then the subcontractor sign-up.
 *
 * @package suburbancm
 */

get_header();

$count     = (int) $GLOBALS['wp_query']->found_posts;
$form_id   = suburbancm_bidder_form_id();
?>
<main id="site-content" class="scm-bids">
	<?php
	suburbancm_page_header(
		[
			'title'          => __( 'Subcontractor', 'suburbancm' ),
			'titleHighlight' => __( 'bid opportunities.', 'suburbancm' ),
			'subtitle'       => __( 'Interested in partnering with us? View current bid opportunities and register your company to hear about future projects. We actively market our projects to local subcontractors.', 'suburbancm' ),
		]
	);
	?>

	<section class="scm-bg-ink">
		<div class="scm-wrap scm-section">
			<header class="scm-bids__head">
				<h2 class="scm-d scm-h-l"><?php esc_html_e( 'Open bids', 'suburbancm' ); ?></h2>
				<span class="scm-bids__count">
					<?php
					/* translators: %d: number of open bids */
					echo esc_html( sprintf( _n( '%d currently open', '%d currently open', $count, 'suburbancm' ), $count ) );
					?>
				</span>
			</header>

			<?php if ( have_posts() ) : ?>
				<ol class="scm-bid-list">
					<?php
					while ( have_posts() ) :
						the_post();
						$due  = suburbancm_field( 'due_date' );
						$type = suburbancm_first_term( get_the_ID(), 'bidding_type' );
						?>
						<li>
							<a class="scm-bid" href="<?php the_permalink(); ?>">
								<span class="scm-bid__due">
									<?php if ( $due ) : ?>
										<span class="scm-bid__due-label"><?php esc_html_e( 'Bids due', 'suburbancm' ); ?></span>
										<span class="scm-d scm-bid__due-date"><?php echo esc_html( suburbancm_date( $due, 'M j' ) ); ?></span>
										<span class="scm-bid__due-year"><?php echo esc_html( suburbancm_date( $due, 'Y' ) ); ?></span>
									<?php else : ?>
										<span class="scm-bid__due-label"><?php esc_html_e( 'Due date TBA', 'suburbancm' ); ?></span>
									<?php endif; ?>
								</span>
								<span class="scm-bid__body">
									<?php if ( $type ) : ?>
										<span class="scm-eyebrow scm-gold"><?php echo esc_html( $type ); ?></span>
									<?php endif; ?>
									<span class="scm-d scm-bid__title"><?php the_title(); ?></span>
									<?php if ( has_excerpt() || get_the_content() ) : ?>
										<span class="scm-bid__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 28 ) ); ?></span>
									<?php endif; ?>
								</span>
								<span class="scm-bid__more"><?php esc_html_e( 'View bid →', 'suburbancm' ); ?></span>
							</a>
						</li>
					<?php endwhile; ?>
				</ol>
			<?php else : ?>
				<div class="scm-empty">
					<div class="scm-empty__text">
						<p class="scm-d scm-h-s"><?php esc_html_e( 'No open bids right now.', 'suburbancm' ); ?></p>
						<p><?php esc_html_e( "New Invitations to Bid are posted here first, with plans, specs and pre-bid meeting details. Register below and we'll let you know when the next project goes out to bid.", 'suburbancm' ); ?></p>
					</div>
					<a class="scm-btn" href="#register"><?php esc_html_e( 'Register your company ↓', 'suburbancm' ); ?></a>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<div id="register">
		<?php
		$panel = [
			'formTitle' => __( 'Get on our bidder list.', 'suburbancm' ),
			'formNote'  => __( "We'll notify you when projects in your trade go out to bid.", 'suburbancm' ),
			'align'     => 'full',
		];
		if ( $form_id ) {
			echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- block output.
				'<!-- wp:suburbancm/form-panel ' . wp_json_encode( $panel + [
					'links' => [ [ 'title' => __( 'Questions about a bid?', 'suburbancm' ), 'text' => __( 'Contact our estimating team', 'suburbancm' ), 'url' => home_url( '/contact/' ) ] ],
				] ) . ' --><!-- wp:wpforms/form-selector {"formId":"' . $form_id . '","displayTitle":false,"displayDesc":false} /--><!-- /wp:suburbancm/form-panel -->'
			);
		} else {
			// No registration form yet: point subcontractors to the contact form (and skip the footer's own band).
			add_filter( 'suburbancm_footer_cta', '__return_false' );
			echo do_blocks( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- block output.
				'<!-- wp:suburbancm/cta-1 ' . wp_json_encode( [
					'title'       => __( 'Get on our bidder list.', 'suburbancm' ),
					'description' => __( 'Send us your company name, trade and contact details, and we\'ll let you know when projects in your trade go out to bid.', 'suburbancm' ),
					'buttonText'  => __( 'Register through our contact form →', 'suburbancm' ),
					'buttonUrl'   => home_url( '/contact/' ),
				] ) . ' /-->'
			);
		}
		?>
	</div>
</main>
<?php
get_footer();
