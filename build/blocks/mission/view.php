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
$imageUrl    = $attributes['imageUrl'] ?? 'https://fakeimg.pl/600x400/cccccc/909090?text=Team+Working';
$imageAlt    = $attributes['imageAlt'] ?? __('Team collaborating on blueprints', 'suburbancm');
$rowReverse  = $attributes['rowReverse'] ?? false;
$rowClass    = $rowReverse ? 'md:flex-row-reverse' : 'md:flex-row';

?>
<section id="mission" class="py-16 lg:py-24 bg-brand-bg-alt-dark opacity-0 transition-opacity duration-700 ease-out animate-on-scroll">
    <div class="max-w-7xl mx-auto px-6 lg:px-8 flex flex-col <?php echo esc_attr( $rowClass ); ?> gap-12 items-center animate-on-scroll">
        <div class="relative w-full opacity-0 translate-y-5 transition-all duration-500 ease-out animate-on-scroll">
            <?php if ( ! empty( $title ) ) : ?>
                <h2 class="text-3xl font-extrabold text-white sm:text-4xl mb-4">
                    <?php echo wp_kses_post( $title ); ?>
                </h2>
            <?php endif; ?>
            <?php if ( ! empty( $description ) ) : ?>
                <p class="text-lg text-brand-text-dark/80 mb-6">
                    <?php echo wp_kses_post( $description ); ?>
                </p>
            <?php endif; ?>
            <?php if ( ! empty( $buttonText ) ) : ?>
                <a href="<?php echo esc_url( $buttonUrl ); ?>" class="btn primary transition duration-200 ease-in-out transform hover:scale-105">
                    <?php echo wp_kses_post( $buttonText ); ?>
                </a>
            <?php endif; ?>
        </div>
        <div class="relative w-full opacity-0 translate-y-5 transition-all duration-500 ease-out animate-on-scroll delay-100">
            <img src="<?php echo esc_url( $imageUrl ); ?>" alt="<?php echo esc_attr( $imageAlt ); ?>" class="rounded-lg shadow-md w-full object-cover">
        </div>
    </div>
</section>