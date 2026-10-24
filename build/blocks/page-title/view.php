<?php
/**
 * Page Title — inner-page hero: headline (optional gold second line), tagline, intro, button, photo band.
 *
 * @package suburbancm
 */

$title           = $attributes['title'] ?? '';
$title_highlight = $attributes['titleHighlight'] ?? '';
$subtitle        = $attributes['subtitle'] ?? '';
$tagline         = $attributes['tagline'] ?? '';
$background      = ( $attributes['background'] ?? 'ink' ) === 'gold' ? 'gold' : 'ink';
$button_text     = $attributes['buttonText'] ?? '';
$button_url      = $attributes['buttonUrl'] ?? '';
$image_id        = $attributes['imageId'] ?? 0;
$image_url       = $attributes['imageUrl'] ?? '';
$image_alt       = $attributes['imageAlt'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'scm-page-title scm-bg-' . $background ] );
?>
<div <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<section class="scm-wrap scm-page-title__text">
		<h1 class="scm-d scm-h-xl">
			<span class="scm-line"><?php echo wp_kses_post( $title ); ?></span>
			<?php if ( '' !== trim( wp_strip_all_tags( $title_highlight ) ) ) : ?>
				<span class="scm-line scm-page-title__highlight"><?php echo wp_kses_post( $title_highlight ); ?></span>
			<?php endif; ?>
		</h1>
		<?php if ( $tagline ) : ?>
			<p class="scm-d scm-page-title__tagline"><?php echo wp_kses_post( $tagline ); ?></p>
		<?php endif; ?>
		<?php if ( $subtitle || ( $button_text && $button_url ) ) : ?>
			<div class="scm-page-title__row">
				<?php if ( $subtitle ) : ?>
					<p class="scm-lede"><?php echo wp_kses_post( $subtitle ); ?></p>
				<?php endif; ?>
				<?php if ( $button_text && $button_url ) : ?>
					<a class="scm-btn<?php echo 'gold' === $background ? ' scm-btn--ink' : ''; ?>" href="<?php echo esc_url( $button_url ); ?>"><?php echo wp_kses_post( $button_text ); ?></a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</section>

	<?php if ( $image_id || $image_url ) : ?>
		<figure class="scm-photo-band">
			<?php
			if ( $image_id ) {
				echo wp_get_attachment_image( $image_id, 'full', false, [ 'alt' => $image_alt, 'sizes' => '100vw' ] );
			} else {
				printf( '<img src="%s" alt="%s">', esc_url( $image_url ), esc_attr( $image_alt ) );
			}
			?>
		</figure>
	<?php endif; ?>
</div>
