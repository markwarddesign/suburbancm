<?php
/**
 * Award Callout — gold band: giant rank, headline, story link; award graphic as a square on the right.
 *
 * @package suburbancm
 */

$image          = $attributes['image'] ?? '';
$image_alt      = $attributes['imageAlt'] ?? '';
$rank           = $attributes['rank'] ?? '#1';
$eyebrow        = $attributes['eyebrow'] ?? '';
$title          = $attributes['title'] ?? '';
$description    = $attributes['description'] ?? '';
$button_text    = $attributes['buttonText'] ?? '';
$button_url     = $attributes['buttonUrl'] ?? '';
$secondary_text = $attributes['secondaryText'] ?? '';
$secondary_url  = $attributes['secondaryUrl'] ?? '';

$is_external = static function ( $url ) {
	$host = wp_parse_url( $url, PHP_URL_HOST );
	return $host && wp_parse_url( home_url(), PHP_URL_HOST ) !== $host;
};
$link_attrs = static function ( $url ) use ( $is_external ) {
	return $is_external( $url ) ? ' target="_blank" rel="noopener"' : '';
};

$wrapper_attributes = get_block_wrapper_attributes(
	[
		'id'    => 'award',
		'class' => 'scm-award scm-bg-gold' . ( $image ? ' has-image' : '' ),
	]
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-award__text">
		<?php if ( $eyebrow ) : ?>
			<p class="scm-eyebrow"><?php echo wp_kses_post( $eyebrow ); ?></p>
		<?php endif; ?>

		<div class="scm-award__head">
			<?php if ( $rank ) : ?>
				<span class="scm-d scm-award__rank" aria-hidden="true"><?php echo esc_html( $rank ); ?></span>
			<?php endif; ?>
			<?php if ( $title ) : ?>
				<h2 class="scm-d scm-h-m"><?php echo wp_kses_post( $title ); ?></h2>
			<?php endif; ?>
		</div>

		<?php if ( $description ) : ?>
			<p class="scm-lede"><?php echo wp_kses_post( $description ); ?></p>
		<?php endif; ?>

		<?php if ( ( $button_text && $button_url ) || ( $secondary_text && $secondary_url ) ) : ?>
			<div class="scm-btns">
				<?php if ( $button_text && $button_url ) : ?>
					<a class="scm-btn scm-btn--ink" href="<?php echo esc_url( $button_url ); ?>"<?php echo $link_attrs( $button_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses_post( $button_text ); ?></a>
				<?php endif; ?>
				<?php if ( $secondary_text && $secondary_url ) : ?>
					<a class="scm-btn scm-btn--line" href="<?php echo esc_url( $secondary_url ); ?>"<?php echo $link_attrs( $secondary_url ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>><?php echo wp_kses_post( $secondary_text ); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>

	<?php if ( $image ) : ?>
		<div class="scm-award__image">
			<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy">
		</div>
	<?php endif; ?>
</section>
