<?php
/**
 * All of the parameters passed to the function where this file is being required are accessible in this scope:
 *
 * @param array    $attributes     The array of attributes for this block.
 * @param string   $content        Rendered block output. ie. <InnerBlocks.Content />.
 * @param WP_Block $block_instance The instance of the WP_Block class that represents the block being rendered.
 *
 * @package suburbancm
 */

$title    = $attributes['title'] ?? '';
$subtitle = $attributes['subtitle'] ?? '';

?>
<section id="page-title" class="bg-gradient-to-br from-brand-bg-alt-dark to-brand-bg-dark flex items-center justify-center text-center py-24 px-4 sm:px-6 lg:px-8 min-h-[50vh]">
    <div class="max-w-3xl">
        <?php if ( ! empty( $title ) ) : ?>
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white leading-tight opacity-0 translate-y-4 transition-all duration-700 ease-out" data-animate-on-load>
                <?php echo wp_kses_post( $title ); ?>
            </h1>
        <?php endif; ?>
        <?php if ( ! empty( $subtitle ) ) : ?>
            <p class="mt-4 text-lg sm:text-xl text-brand-text-dark/80 max-w-2xl mx-auto opacity-0 translate-y-4 transition-all duration-700 ease-out delay-200" data-animate-on-load>
                <?php echo wp_kses_post( $subtitle ); ?>
            </p>
        <?php endif; ?>
    </div>
</section>