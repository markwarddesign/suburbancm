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

$title              = $attributes['title'] ?? '';
$subtitle           = $attributes['subtitle'] ?? '';
$primaryButtonText  = $attributes['primaryButtonText'] ?? '';
$primaryButtonUrl   = $attributes['primaryButtonUrl'] ?? '#';
$secondaryButtonText = $attributes['secondaryButtonText'] ?? '';
$secondaryButtonUrl = $attributes['secondaryButtonUrl'] ?? '#';

?>
<section id="cta2" class="bg-[#1f1f1f] opacity-0 transition-opacity duration-700 ease-out animate-on-scroll bg-dark-wave">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
        <h2 class="text-3xl font-extrabold tracking-tight text-[#ffffff] sm:text-4xl">
            <span class="block"><?php echo wp_kses_post( $title ); ?></span>
            <span class="block text-[#e4d198]"><?php echo wp_kses_post( $subtitle ); ?></span>
        </h2>
        <div class="mt-8 flex flex-col md:flex-row lg:mt-0 gap-3 lg:flex-shrink-0">
            <div class="md:mb-0 md:inline-flex rounded-md shadow">
                <a href="<?php echo esc_url( $primaryButtonUrl ); ?>" class="w-full btn primary-inverse transition duration-200 hover:scale-105 transform">
                    <?php echo wp_kses_post( $primaryButtonText ); ?>
                </a>
            </div>
            <div class="md:inline-flex rounded-md shadow">
                <a href="<?php echo esc_url( $secondaryButtonUrl ); ?>" class="w-full btn secondary transition duration-200 hover:scale-105 transform">
                    <?php echo wp_kses_post( $secondaryButtonText ); ?>
                </a>
            </div>
        </div>
    </div>
</section>