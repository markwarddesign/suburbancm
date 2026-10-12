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

$title = $attributes['title'] ?? __('Additional Actions', 'suburbancm');
$title1 = $attributes['title1'] ?? '';
$description1 = $attributes['description1'] ?? '';
$link1 = $attributes['link1'] ?? '';
$linkText1 = $attributes['linkText1'] ?? '';
$icon1 = $attributes['icon1'] ?? '';
$title2 = $attributes['title2'] ?? '';
$description2 = $attributes['description2'] ?? '';
$link2 = $attributes['link2'] ?? '';
$linkText2 = $attributes['linkText2'] ?? '';
$icon2 = $attributes['icon2'] ?? '';

?>
<section aria-labelledby="additional-actions-heading" class="pt-12 pb-16 bg-[#1f1f1f] overflow-hidden">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <h2 id="additional-actions-heading" class="text-3xl font-bold text-center text-[#e4d198] sm:text-4xl mb-12 opacity-0 transition-opacity duration-700 ease-out animate-on-scroll "><?php echo wp_kses_post( $title ); ?></h2>
        <div class="flex flex-col md:flex-row md:space-x-8 space-y-8 md:space-y-0">
            <!-- First Action -->
            <div class="md:w-1/2 bg-[#a38f50] rounded-lg shadow-xl p-6 text-center flex flex-col items-center opacity-0 transition-opacity duration-700 ease-out animate-on-scroll ">
                <i class="fas <?php echo esc_attr( $icon1 ); ?> w-12 h-12 text-[#1f1f1f] mb-4 text-4xl"></i>
                <h3 class="text-xl font-semibold text-[#fff] mb-2"><?php echo wp_kses_post( $title1 ); ?></h3>
                <p class="text-[#fff] mb-5 flex-grow"><?php echo wp_kses_post( $description1 ); ?></p>
                <a href="<?php echo esc_url( $link1 ); ?>" class="btn secondary">
                    <?php echo wp_kses_post( $linkText1 ); ?>
                </a>
            </div>

            <!-- Second Action -->
            <div class="md:w-1/2 bg-[#2a2a2a] rounded-lg shadow-xl p-6 text-center flex flex-col items-center opacity-0 transition-opacity duration-700 ease-out animate-on-scroll ">
                <i class="fas <?php echo esc_attr( $icon2 ); ?> w-12 h-12 text-[#a38f50] mb-4 text-4xl"></i>
                <h3 class="text-xl font-semibold text-[#fff] mb-2"><?php echo wp_kses_post( $title2 ); ?></h3>
                <p class="text-[#cccccc] mb-5 flex-grow"><?php echo wp_kses_post( $description2 ); ?></p>
                <a href="<?php echo esc_url( $link2 ); ?>" class="btn primary">
                    <?php echo wp_kses_post( $linkText2 ); ?>
                </a>
            </div>
        </div>
    </div>
</section>