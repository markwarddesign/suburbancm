<?php
/**
 * Award Callout block – frontend render.
 *
 * @param array    $attributes     The array of attributes for this block.
 * @param string   $content        Rendered block output.
 * @param WP_Block $block_instance The block instance.
 *
 * @package suburbancm
 */

$image          = $attributes['image'] ?? '';
$image_alt      = $attributes['imageAlt'] ?? '';
$eyebrow        = $attributes['eyebrow'] ?? '';
$title          = $attributes['title'] ?? '';
$description    = $attributes['description'] ?? '';
$button_text    = $attributes['buttonText'] ?? '';
$button_url     = $attributes['buttonUrl'] ?? '';
$secondary_text = $attributes['secondaryText'] ?? '';
$secondary_url  = $attributes['secondaryUrl'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes(
	[
		'id'    => 'award-callout',
		'class' => 'suburbancm-award-callout py-16 lg:py-24 bg-[#1f1f1f]',
	]
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
		<div class="relative overflow-hidden max-w-5xl mx-auto bg-[#2a2a2a] p-8 md:p-12 rounded-xl shadow-xl border border-[#e4d198]/30 opacity-0 translate-y-5 transition-all duration-700 ease-out animate-on-scroll">
			<div class="pointer-events-none absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-[#80703a] via-[#e4d198] to-[#80703a]"></div>

			<div class="flex flex-col lg:flex-row items-center text-center lg:text-left gap-8 lg:gap-12">
				<div class="suburbancm-award-callout__badge flex-shrink-0 w-40 h-40 md:w-48 md:h-48 flex items-center justify-center">
					<?php if ( ! empty( $image ) ) : ?>
						<img src="<?php echo esc_url( $image ); ?>"
							 alt="<?php echo esc_attr( $image_alt ); ?>"
							 class="w-full h-full object-contain drop-shadow-lg"
							 loading="lazy">
					<?php else : ?>
						<div class="w-32 h-32 md:w-40 md:h-40 rounded-full bg-[#e4d198] flex items-center justify-center shadow-md">
							<i class="fas fa-trophy text-[#80703a]" style="font-size:72px;" aria-hidden="true"></i>
						</div>
					<?php endif; ?>
				</div>

				<div class="flex-1">
					<?php if ( ! empty( $eyebrow ) ) : ?>
						<p class="text-sm font-semibold uppercase tracking-widest text-[#a38f50] mb-3">
							<?php echo wp_kses_post( $eyebrow ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $title ) ) : ?>
						<h2 class="text-3xl md:text-4xl font-bold text-[#e4d198] mb-4">
							<?php echo wp_kses_post( $title ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( ! empty( $description ) ) : ?>
						<p class="text-lg md:text-xl text-[#e4d198]/90 leading-relaxed">
							<?php echo wp_kses_post( $description ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $button_text ) || ( ! empty( $secondary_text ) && ! empty( $secondary_url ) ) ) : ?>
						<div class="mt-8 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 sm:gap-6">
							<?php if ( ! empty( $button_text ) ) : ?>
								<a href="<?php echo esc_url( $button_url ); ?>"
								   target="_blank" rel="noopener"
								   class="inline-block bg-[#a38f50] text-[#1f1f1f] hover:bg-[#e4d198] hover:text-[#a38f50] font-semibold px-8 py-3 border border-transparent rounded-md shadow transition duration-200 hover:scale-105 transform">
									<?php echo wp_kses_post( $button_text ); ?>
								</a>
							<?php endif; ?>

							<?php if ( ! empty( $secondary_text ) && ! empty( $secondary_url ) ) : ?>
								<a href="<?php echo esc_url( $secondary_url ); ?>"
								   target="_blank" rel="noopener"
								   class="inline-flex items-center gap-2 text-[#e4d198] hover:text-white font-semibold transition duration-200">
									<i class="fas fa-play-circle" aria-hidden="true"></i>
									<?php echo wp_kses_post( $secondary_text ); ?>
								</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
