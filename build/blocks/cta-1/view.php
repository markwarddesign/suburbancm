<?php
/**
 * CTA One — gold call-to-action band: big headline, optional line of text, one charcoal button.
 * The footer adds this above the footer on every page except Home.
 *
 * @package suburbancm
 */

$title       = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$button_text = $attributes['buttonText'] ?? '';
$button_url  = $attributes['buttonUrl'] ?? '#';

$wrapper_attributes = get_block_wrapper_attributes( [ 'id' => 'cta1', 'class' => 'scm-cta scm-bg-gold' ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section--sm scm-cta__inner">
		<div class="scm-cta__text">
			<?php if ( $title ) : ?>
				<h2 class="scm-d scm-h-l"><?php echo wp_kses_post( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $description ) : ?>
				<p class="scm-lede"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
		</div>
		<?php if ( $button_text ) : ?>
			<a class="scm-btn scm-btn--ink" href="<?php echo esc_url( $button_url ); ?>"><?php echo wp_kses_post( $button_text ); ?></a>
		<?php endif; ?>
	</div>
</section>
