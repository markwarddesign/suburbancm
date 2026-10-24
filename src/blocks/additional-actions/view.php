<?php
/**
 * Additional Actions — two side-by-side boxes on bone: a filled charcoal one and an outlined one.
 *
 * @package suburbancm
 */

$title = $attributes['title'] ?? __( 'Additional Actions', 'suburbancm' );
$boxes = [
	[
		'title' => $attributes['title1'] ?? '',
		'text'  => $attributes['description1'] ?? '',
		'url'   => $attributes['link1'] ?? '',
		'label' => $attributes['linkText1'] ?? '',
		'class' => 'scm-action--filled',
		'btn'   => 'scm-btn',
	],
	[
		'title' => $attributes['title2'] ?? '',
		'text'  => $attributes['description2'] ?? '',
		'url'   => $attributes['link2'] ?? '',
		'label' => $attributes['linkText2'] ?? '',
		'class' => 'scm-action--outline',
		'btn'   => 'scm-btn scm-btn--line',
	],
];

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'scm-actions scm-bg-bone' ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?> aria-labelledby="scm-actions-title">
	<div class="scm-wrap scm-section--sm scm-actions__grid">
		<h2 id="scm-actions-title" class="screen-reader-text"><?php echo wp_kses_post( $title ); ?></h2>
		<?php foreach ( $boxes as $box ) : ?>
			<?php if ( ! $box['title'] && ! $box['text'] ) { continue; } ?>
			<div class="scm-action <?php echo esc_attr( $box['class'] ); ?>">
				<h3 class="scm-d scm-h-s"><?php echo wp_kses_post( $box['title'] ); ?></h3>
				<?php if ( $box['text'] ) : ?>
					<p><?php echo wp_kses_post( $box['text'] ); ?></p>
				<?php endif; ?>
				<?php if ( $box['label'] && $box['url'] ) : ?>
					<a class="<?php echo esc_attr( $box['btn'] ); ?>" href="<?php echo esc_url( $box['url'] ); ?>"><?php echo wp_kses_post( $box['label'] ); ?></a>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	</div>
</section>
