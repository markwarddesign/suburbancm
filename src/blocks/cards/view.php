<?php
/**
 * Values List — heading, then big ruled rows: a large title beside a short description.
 *
 * @package suburbancm
 */

$title      = $attributes['title'] ?? '';
$cards      = array_filter( (array) ( $attributes['cards'] ?? [] ), static fn( $c ) => ! empty( $c['cardTitle'] ) || ! empty( $c['description'] ) );
$background = ( $attributes['background'] ?? 'bone' ) === 'ink' ? 'ink' : 'bone';

if ( ! $title && ! $cards ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'scm-values scm-bg-' . $background ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section">
		<?php if ( $title ) : ?>
			<h2 class="scm-d scm-h-l scm-values__title"><?php echo wp_kses_post( $title ); ?></h2>
		<?php endif; ?>
		<?php foreach ( $cards as $card ) : ?>
			<div class="scm-values__row">
				<h3 class="scm-d"><?php echo wp_kses_post( $card['cardTitle'] ?? '' ); ?></h3>
				<?php if ( ! empty( $card['description'] ) ) : ?>
					<p><?php echo wp_kses_post( $card['description'] ); ?></p>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>
