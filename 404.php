<?php
/**
 * 404 — "Not on the plans." A blueprint grid, a huge 404 and the ways back.
 *
 * @package suburbancm
 */

get_header();
?>

<main id="site-content" class="scm-404">
	<section class="scm-404__sheet">
		<div class="scm-wrap scm-404__inner">
			<p class="scm-404__ref" aria-hidden="true">
				<span><?php esc_html_e( 'Sheet', 'suburbancm' ); ?> A-404</span>
				<span><?php esc_html_e( 'Rev. —', 'suburbancm' ); ?></span>
				<span><?php esc_html_e( 'Scale: none', 'suburbancm' ); ?></span>
			</p>

			<div class="scm-404__mark scm-d" aria-hidden="true">404</div>

			<h1 class="scm-d scm-h-xl">
				<span class="scm-line"><?php esc_html_e( 'This page', 'suburbancm' ); ?></span>
				<span class="scm-line scm-gold"><?php esc_html_e( "isn't on the plans.", 'suburbancm' ); ?></span>
			</h1>

			<div class="scm-404__row">
				<p class="scm-lede"><?php esc_html_e( 'It may have been moved, demolished, or never made it past permitting. Here are a few solid places to stand instead.', 'suburbancm' ); ?></p>
				<div class="scm-btns">
					<a class="scm-btn" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'suburbancm' ); ?></a>
					<a class="scm-btn scm-btn--line" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Ask our team', 'suburbancm' ); ?></a>
				</div>
			</div>

			<nav class="scm-404__links" aria-label="<?php esc_attr_e( 'Popular pages', 'suburbancm' ); ?>">
				<a href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><span class="scm-404__no">01</span><?php esc_html_e( 'Projects', 'suburbancm' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><span class="scm-404__no">02</span><?php esc_html_e( 'Services', 'suburbancm' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/the-suburban-difference/' ) ); ?>"><span class="scm-404__no">03</span><?php esc_html_e( 'The Difference', 'suburbancm' ); ?></a>
				<a href="<?php echo esc_url( home_url( '/bidding/' ) ); ?>"><span class="scm-404__no">04</span><?php esc_html_e( 'Bid opportunities', 'suburbancm' ); ?></a>
			</nav>
		</div>
	</section>
</main>

<?php
get_footer();
