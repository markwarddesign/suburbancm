<?php
/**
 * CTA Two — charcoal band: headline (optional gold second line) and two buttons.
 *
 * @package suburbancm
 */

$title          = $attributes['title'] ?? '';
$subtitle       = $attributes['subtitle'] ?? '';
$primary_text   = $attributes['primaryButtonText'] ?? '';
$primary_url    = $attributes['primaryButtonUrl'] ?? '';
$secondary_text = $attributes['secondaryButtonText'] ?? '';
$secondary_url  = $attributes['secondaryButtonUrl'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes( [ 'id' => 'cta2', 'class' => 'scm-cta scm-cta--ink scm-bg-ink-2' ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section--sm scm-cta__inner">
		<div class="scm-cta__text">
			<h2 class="scm-d scm-h-l">
				<span class="scm-line"><?php echo wp_kses_post( $title ); ?></span>
				<?php if ( $subtitle ) : ?>
					<span class="scm-line scm-gold"><?php echo wp_kses_post( $subtitle ); ?></span>
				<?php endif; ?>
			</h2>
		</div>
		<div class="scm-btns">
			<?php if ( $secondary_text && $secondary_url ) : ?>
				<a class="scm-btn scm-btn--line" href="<?php echo esc_url( $secondary_url ); ?>"><?php echo wp_kses_post( $secondary_text ); ?></a>
			<?php endif; ?>
			<?php if ( $primary_text && $primary_url ) : ?>
				<a class="scm-btn" href="<?php echo esc_url( $primary_url ); ?>"><?php echo wp_kses_post( $primary_text ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>
