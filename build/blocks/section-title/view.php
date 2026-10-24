<?php
/**
 * Section Title — big condensed heading and optional intro line, in the colours of its section.
 *
 * @package suburbancm
 */

$title       = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$level       = (int) ( $attributes['level'] ?? 2 );
$level       = ( $level >= 1 && $level <= 5 ) ? $level : 2;
$align       = in_array( $attributes['align'] ?? 'center', [ 'left', 'center', 'right' ], true ) ? $attributes['align'] : 'center';
$tag         = 'h' . $level;
$size        = $level <= 2 ? 'scm-h-l' : 'scm-h-m';

if ( ! $title && ! $description ) {
	return;
}
?>
<div <?php echo get_block_wrapper_attributes( [ 'class' => 'scm-section-title is-' . $align ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( $title ) : ?>
		<<?php echo esc_attr( $tag ); ?> class="scm-d <?php echo esc_attr( $size ); ?>"><?php echo wp_kses_post( $title ); ?></<?php echo esc_attr( $tag ); ?>>
	<?php endif; ?>
	<?php if ( $description ) : ?>
		<p class="scm-section-title__text"><?php echo wp_kses_post( $description ); ?></p>
	<?php endif; ?>
</div>
