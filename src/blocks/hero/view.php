<?php
/**
 * Hero — big two-line headline, intro, two buttons, optional full-bleed photo below.
 * Used for the home hero and as a page hero (Services, The Difference).
 *
 * @package suburbancm
 */

$heading_line1        = $attributes['headingLine1'] ?? 'Building your vision.';
$heading_highlight    = $attributes['headingHighlight'] ?? 'Managing every detail.';
$paragraph            = $attributes['paragraph'] ?? '';
$button1_text         = $attributes['button1Text'] ?? '';
$button1_link         = $attributes['button1Link'] ?? '';
$button2_text         = $attributes['button2Text'] ?? '';
$button2_link         = $attributes['button2Link'] ?? '';
$background_image_id  = $attributes['backgroundImageId'] ?? 0;
$background_image_url = $attributes['backgroundImageUrl'] ?? '';
$image_alt            = $attributes['imageAlt'] ?? '';
$image_caption        = $attributes['imageCaption'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'scm-hero' ] );
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<section class="scm-wrap scm-hero__text">
		<h1 class="scm-d scm-h-xl">
			<span class="scm-line"><?php echo wp_kses_post( $heading_line1 ); ?></span>
			<?php if ( '' !== trim( wp_strip_all_tags( $heading_highlight ) ) ) : ?>
				<span class="scm-line scm-gold"><?php echo wp_kses_post( $heading_highlight ); ?></span>
			<?php endif; ?>
		</h1>

		<div class="scm-hero__row">
			<?php if ( ! empty( $paragraph ) ) : ?>
				<p class="scm-lede"><?php echo wp_kses_post( $paragraph ); ?></p>
			<?php endif; ?>

			<?php if ( ( $button1_text && $button1_link ) || ( $button2_text && $button2_link ) ) : ?>
				<div class="scm-btns">
					<?php if ( $button1_text && $button1_link ) : ?>
						<a class="scm-btn" href="<?php echo esc_url( $button1_link ); ?>"><?php echo wp_kses_post( $button1_text ); ?></a>
					<?php endif; ?>
					<?php if ( $button2_text && $button2_link ) : ?>
						<a class="scm-btn scm-btn--line" href="<?php echo esc_url( $button2_link ); ?>"><?php echo wp_kses_post( $button2_text ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>
	</section>

	<?php if ( $background_image_id || $background_image_url ) : ?>
		<figure class="scm-photo-band">
			<?php
			if ( $background_image_id ) {
				echo wp_get_attachment_image( $background_image_id, 'full', false, [ 'alt' => $image_alt, 'sizes' => '100vw' ] );
			} else {
				printf( '<img src="%s" alt="%s">', esc_url( $background_image_url ), esc_attr( $image_alt ) );
			}
			?>
			<?php if ( $image_caption ) : ?>
				<figcaption><?php echo esc_html( $image_caption ); ?></figcaption>
			<?php endif; ?>
		</figure>
	<?php endif; ?>
</div>
