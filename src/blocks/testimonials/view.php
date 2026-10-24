<?php
/**
 * Testimonials — large pull quotes with a gold opening mark. No slider: each quote gets the room.
 *
 * @package suburbancm
 */

$title        = $attributes['title'] ?? '';
$testimonials = array_filter(
	(array) ( $attributes['testimonials'] ?? [] ),
	static fn( $t ) => ! empty( $t['quote'] )
);

if ( ! $testimonials ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'scm-quotes scm-bg-ink-2' ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section">
		<?php if ( $title ) : ?>
			<h2 class="scm-eyebrow scm-gold scm-quotes__title"><?php echo wp_kses_post( $title ); ?></h2>
		<?php endif; ?>

		<?php foreach ( $testimonials as $testimonial ) : ?>
			<figure class="scm-quote">
				<div class="scm-d scm-quote__mark" aria-hidden="true">“</div>
				<div class="scm-quote__body">
					<blockquote><?php echo wp_kses_post( trim( $testimonial['quote'], " \t\n\r\0\x0B\"“”" ) ); ?></blockquote>
					<?php if ( ! empty( $testimonial['name'] ) || ! empty( $testimonial['role'] ) ) : ?>
						<figcaption>
							<?php if ( ! empty( $testimonial['image'] ) ) : ?>
								<img src="<?php echo esc_url( $testimonial['image'] ); ?>" alt="<?php echo esc_attr( $testimonial['alt'] ?? '' ); ?>" loading="lazy">
							<?php endif; ?>
							<?php if ( ! empty( $testimonial['name'] ) ) : ?>
								<span class="scm-quote__name"><?php echo wp_kses_post( $testimonial['name'] ); ?></span>
							<?php endif; ?>
							<?php if ( ! empty( $testimonial['role'] ) ) : ?>
								<span class="scm-quote__role"><?php echo wp_kses_post( $testimonial['role'] ); ?></span>
							<?php endif; ?>
						</figcaption>
					<?php endif; ?>
				</div>
			</figure>
		<?php endforeach; ?>
	</div>
</section>
