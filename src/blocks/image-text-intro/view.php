<?php
/**
 * Split Text — heading (and optional image) on the left; lead line, paragraphs and tag chips on the right.
 * Paragraphs are separated by a blank line (two line breaks) in the editor.
 *
 * @package suburbancm
 */

$title       = $attributes['title'] ?? '';
$image       = $attributes['image'] ?? '';
$image_alt   = $attributes['imageAlt'] ?? '';
$lead        = $attributes['lead'] ?? '';
$text        = $attributes['text'] ?? '';
$chips_label = $attributes['chipsLabel'] ?? '';
$chips       = array_values( array_filter( (array) ( $attributes['chips'] ?? [] ), static fn( $c ) => '' !== trim( (string) $c ) ) );
$chip_links  = (array) ( $attributes['chipLinks'] ?? [] );
$background  = ( $attributes['background'] ?? 'bone' ) === 'ink' ? 'ink' : 'bone';

$paragraphs = array_filter( array_map( 'trim', preg_split( '#(?:<br\s*/?>\s*){2,}|\n{2,}#i', (string) $text ) ) );

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'scm-split scm-bg-' . $background ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section scm-split__inner">
		<div class="scm-split__head">
			<?php if ( $title ) : ?>
				<h2 class="scm-d scm-h-l"><?php echo wp_kses_post( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $image ) : ?>
				<img class="scm-split__image" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy">
			<?php endif; ?>
		</div>
		<div class="scm-split__body">
			<?php if ( $lead ) : ?>
				<p class="scm-split__lead"><?php echo wp_kses_post( $lead ); ?></p>
			<?php endif; ?>
			<?php foreach ( $paragraphs as $paragraph ) : ?>
				<p><?php echo wp_kses_post( $paragraph ); ?></p>
			<?php endforeach; ?>
			<?php if ( $chips ) : ?>
				<div class="scm-split__chips">
					<?php if ( $chips_label ) : ?>
						<p class="scm-eyebrow"><?php echo esc_html( $chips_label ); ?></p>
					<?php endif; ?>
					<ul>
						<?php foreach ( $chips as $i => $chip ) : ?>
							<li>
								<?php if ( ! empty( $chip_links[ $i ] ) ) : ?>
									<a class="is-linked" href="<?php echo esc_url( $chip_links[ $i ] ); ?>"><?php echo esc_html( $chip ); ?></a>
								<?php else : ?>
									<span><?php echo esc_html( $chip ); ?></span>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
