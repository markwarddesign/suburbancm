<?php
/**
 * Mission — gold band: small label, the mission as a big statement, a paragraph, optional button and photo.
 * Older blocks without a statement show their title as the headline instead.
 *
 * @package suburbancm
 */

$title       = $attributes['title'] ?? '';
$quote       = $attributes['quote'] ?? '';
$description = $attributes['description'] ?? '';
$button_text = $attributes['buttonText'] ?? '';
$button_url  = $attributes['buttonUrl'] ?? '';
$image_url   = $attributes['imageUrl'] ?? '';
$image_alt   = $attributes['imageAlt'] ?? '';
$reverse     = ! empty( $attributes['rowReverse'] );

$wrapper_attributes = get_block_wrapper_attributes(
	[
		'id'    => 'mission',
		'class' => 'scm-mission scm-bg-gold' . ( $image_url ? ' has-image' : '' ) . ( $reverse ? ' is-reversed' : '' ),
	]
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section scm-mission__inner">
		<div class="scm-mission__text">
			<?php if ( $quote ) : ?>
				<?php if ( $title ) : ?>
					<p class="scm-eyebrow"><?php echo wp_kses_post( $title ); ?></p>
				<?php endif; ?>
				<blockquote class="scm-d scm-mission__quote"><?php echo wp_kses_post( $quote ); ?></blockquote>
			<?php elseif ( $title ) : ?>
				<h2 class="scm-d scm-h-l"><?php echo wp_kses_post( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $description ) : ?>
				<p class="scm-lede"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
			<?php if ( $button_text && $button_url ) : ?>
				<a class="scm-btn scm-btn--ink" href="<?php echo esc_url( $button_url ); ?>"><?php echo wp_kses_post( $button_text ); ?></a>
			<?php endif; ?>
		</div>
		<?php if ( $image_url ) : ?>
			<div class="scm-mission__image">
				<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy">
			</div>
		<?php endif; ?>
	</div>
</section>
