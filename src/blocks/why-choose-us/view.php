<?php
/**
 * Feature Grid — heading with intro text or a link, then points under gold rules.
 *
 * @package suburbancm
 */

$title       = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$items       = array_filter( (array) ( $attributes['items'] ?? [] ), static fn( $i ) => ! empty( $i['title'] ) || ! empty( $i['description'] ) );
$button_text = $attributes['buttonText'] ?? '';
$button_link = $attributes['buttonLink'] ?? '';
$background  = ( $attributes['background'] ?? 'ink' ) === 'bone' ? 'bone' : 'ink';

// The old default pointed at an anchor that no longer exists.
if ( '#cta1' === $button_link ) {
	$button_link = home_url( '/contact/' );
}

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'scm-features scm-bg-' . $background ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section">
		<header class="scm-features__head">
			<?php if ( $title ) : ?>
				<h2 class="scm-d scm-h-l"><?php echo wp_kses_post( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $description || ( $button_text && $button_link ) ) : ?>
				<div class="scm-features__aside">
					<?php if ( $description ) : ?>
						<p class="scm-lede"><?php echo wp_kses_post( $description ); ?></p>
					<?php endif; ?>
					<?php if ( $button_text && $button_link ) : ?>
						<a class="scm-link" href="<?php echo esc_url( $button_link ); ?>"><?php echo wp_kses_post( $button_text ); ?></a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</header>
		<?php if ( $items ) : ?>
			<div class="scm-features__grid">
				<?php foreach ( $items as $item ) : ?>
					<div class="scm-feature scm-reveal">
						<?php if ( ! empty( $item['title'] ) ) : ?>
							<h3 class="scm-d"><?php echo wp_kses_post( $item['title'] ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $item['description'] ) ) : ?>
							<p><?php echo wp_kses_post( $item['description'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
