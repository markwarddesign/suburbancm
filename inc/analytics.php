<?php
/**
 * Google Analytics 4. Loads only on the live site and never for logged-in editors,
 * so admin browsing and local builds don't skew the numbers.
 *
 * @package suburbancm
 */

/**
 * GA4 measurement ID for suburbancm.com (property "SuburbanCM (suburbancm.com)").
 *
 * @return string
 */
function suburbancm_ga4_id() {
	return (string) apply_filters( 'suburbancm_ga4_id', 'G-Z8L7K5413C' );
}

/**
 * Should this request be counted?
 *
 * @return bool
 */
function suburbancm_should_track() {
	$live_host = apply_filters( 'suburbancm_ga4_host', 'suburbancm.com' );
	$host      = wp_parse_url( home_url(), PHP_URL_HOST );

	return suburbancm_ga4_id()
		&& $host === $live_host
		&& ! is_preview()
		&& ! is_customize_preview()
		&& ! current_user_can( 'edit_posts' );
}

/**
 * Print the Google tag as early in <head> as WordPress allows.
 */
function suburbancm_print_ga4() {
	if ( ! suburbancm_should_track() ) {
		return;
	}
	$id = suburbancm_ga4_id();
	?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr( $id ); ?>"></script>
<script>
window.dataLayer = window.dataLayer || [];
function gtag(){dataLayer.push(arguments);}
gtag('js', new Date());
gtag('config', <?php echo wp_json_encode( $id ); ?>);
</script>
	<?php
}
add_action( 'wp_head', 'suburbancm_print_ga4', 1 );
