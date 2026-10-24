<?php
/**
 * Showcase Card — image beside a heading and text, on a raised charcoal panel.
 *
 * @package suburbancm
 */

$image     = $attributes['image'] ?? '';
$image_alt = $attributes['imageAlt'] ?? '';
$title     = $attributes['title'] ?? '';
$text      = $attributes['text'] ?? '';
?>
<section <?php echo get_block_wrapper_attributes( [ 'class' => 'scm-showcase scm-bg-ink' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section--sm">
		<div class="scm-showcase__panel">
			<?php if ( $image ) : ?>
				<img class="scm-showcase__image" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy">
			<?php endif; ?>
			<div class="scm-showcase__text">
				<?php if ( $title ) : ?>
					<h2 class="scm-d scm-h-m"><?php echo wp_kses_post( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $text ) : ?>
					<p><?php echo wp_kses_post( $text ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
