<?php
/**
 * Facts Strip — big gold numbers, each with a short supporting line.
 *
 * @package suburbancm
 */

$items      = array_filter( (array) ( $attributes['items'] ?? [] ), static fn( $i ) => ! empty( $i['value'] ) );
$background = ( $attributes['background'] ?? 'ink' ) === 'gold' ? 'gold' : 'ink';

if ( ! $items ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'scm-facts scm-bg-' . $background ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<dl class="scm-wrap scm-facts__grid">
		<?php foreach ( $items as $item ) : ?>
			<div class="scm-fact">
				<dt class="scm-d scm-fact__value"><?php echo esc_html( $item['value'] ); ?></dt>
				<dd class="scm-fact__label"><?php echo esc_html( $item['label'] ?? '' ); ?></dd>
			</div>
		<?php endforeach; ?>
	</dl>
</section>
