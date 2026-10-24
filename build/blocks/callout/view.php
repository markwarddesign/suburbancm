<?php
/**
 * Safety Callout — gold band: headline, paragraph, bold closing line and button; heavy-ruled list beside it.
 *
 * @package suburbancm
 */

$title       = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$list        = array_filter( (array) ( $attributes['list'] ?? [] ), static fn( $i ) => '' !== trim( wp_strip_all_tags( (string) $i ) ) );
$after_text  = $attributes['afterText'] ?? '';
$button_text = $attributes['buttonText'] ?? '';
$button_url  = $attributes['buttonUrl'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'scm-callout scm-bg-gold' ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section scm-callout__inner">
		<div class="scm-callout__text">
			<?php if ( $title ) : ?>
				<h2 class="scm-d scm-h-l"><?php echo wp_kses_post( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $description ) : ?>
				<p class="scm-lede"><?php echo wp_kses_post( $description ); ?></p>
			<?php endif; ?>
			<?php if ( $after_text ) : ?>
				<p class="scm-callout__after"><?php echo wp_kses_post( $after_text ); ?></p>
			<?php endif; ?>
			<?php if ( $button_text && $button_url ) : ?>
				<a class="scm-btn scm-btn--ink" href="<?php echo esc_url( $button_url ); ?>"><?php echo wp_kses_post( $button_text ); ?></a>
			<?php endif; ?>
		</div>
		<?php if ( $list ) : ?>
			<ul class="scm-rules scm-callout__list">
				<?php foreach ( $list as $item ) : ?>
					<li><?php echo wp_kses_post( $item ); ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
