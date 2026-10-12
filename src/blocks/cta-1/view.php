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

$title       = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$buttonText  = $attributes['buttonText'] ?? '';
$buttonUrl   = $attributes['buttonUrl'] ?? '#';

?>
<section id="cta1" class="bg-[#80703a] text-[#e4d198] opacity-0 transition-opacity duration-700 ease-out animate-on-scroll">
    <div class="max-w-4xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8 text-center">
        <?php if ( ! empty( $title ) ) : ?>
            <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl text-white">
                <?php echo wp_kses_post( $title ); ?>
            </h2>
        <?php endif; ?>
        <?php if ( ! empty( $description ) ) : ?>
            <p class="mt-4 text-lg leading-6 text-[#cccccc]">
                <?php echo wp_kses_post( $description ); ?>
            </p>
        <?php endif; ?>
        <?php if ( ! empty( $buttonText ) ) : ?>
            <div class="mt-8">
                <a href="<?php echo esc_url( $buttonUrl ); ?>" class="inline-block bg-[#a38f50] text-[#1f1f1f] hover:bg-[#e4d198] hover:text-[#a38f50] font-semibold px-8 py-3 border border-transparent rounded-md shadow transition duration-200 hover:scale-105 transform">
                    <?php echo wp_kses_post( $buttonText ); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>
</section>
