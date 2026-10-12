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

$title = $attributes['title'] ?? __('Building Trust, Delivering Excellence', 'suburbancm');
$description = $attributes['description'] ?? __('We bring expertise, integrity, and a commitment to quality to every project, ensuring your vision becomes a reality.', 'suburbancm');
$items = $attributes['items'] ?? [
    [
        'icon' => 'fa-solid fa-check',
        'title' => __('Expertise', 'suburbancm'),
        'description' => __('Our team has years of experience in construction management, ensuring your project is in capable hands.', 'suburbancm'),
    ],
    [
        'icon' => 'fa-solid fa-users',
        'title' => __('Collaboration', 'suburbancm'),
        'description' => __('We work closely with you and your team to ensure every detail is managed effectively.', 'suburbancm'),
    ],
    [
        'icon' => 'fa-solid fa-clock',
        'title' => __('Timeliness', 'suburbancm'),
        'description' => __('We understand the importance of deadlines and work diligently to keep your project on track.', 'suburbancm'),
    ],
];
$button_text = $attributes['buttonText'] ?? __('Request Your Consultation', 'suburbancm');
$button_link = $attributes['buttonLink'] ?? '#cta1';
$wrapper_attributes = get_block_wrapper_attributes(); // Base attributes (includes class, alignment etc.)
$extra_classes = 'relative z-1 w-full flex items-center justify-center text-center py-20 px-4 sm:px-6 lg:px-8 z-10 bg-[#1f1f1f] text-[#e4d198] antialiased'; // Updated classes
$style_attribute = '';

// Manually merge the extra classes into the wrapper attributes string
$wrapper_attributes = str_replace( 'class="', 'class="' . esc_attr( $extra_classes ) . ' ', $wrapper_attributes );
?>

<section id="why-choose-us" <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="max-w-3xl mx-auto text-center mb-12 lg:mb-16">
            <h2 class="text-3xl font-extrabold text-[#e4d198] sm:text-4xl">
                <?php echo wp_kses_post( $title ); ?>
            </h2>
            <p class="mt-4 text-lg text-[#cccccc]">
                <?php echo wp_kses_post( $description ); ?>
            </p>
        </div>


        <?php if($items): ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 mb-16">
            <?php foreach ( $items as $index => $item ) : ?>
                <div class="text-center opacity-0 translate-y-5 transition-all duration-500 ease-out animate-on-scroll delay-<?php echo esc_attr( ( $index + 1 ) * 100 ); ?>">
                    <div class="inline-flex items-center justify-center p-3 bg-[#e4d198]/50 rounded-full mb-4 h-20 w-20">
                        <i class="fas <?php echo esc_attr( $item['icon'] ); ?> text-3xl text-[#e4d198]"></i>
                    </div>
                    <h4 class="text-xl font-semibold text-white mb-2">
                        <?php echo wp_kses_post( $item['title'] ); ?>
                    </h4>
                    <p class="text-sm text-white leading-relaxed">
                        <?php echo wp_kses_post( $item['description'] ); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    
        <?php if ( ! empty( $button_text ) && ! empty( $button_link ) ) : ?>
        <div class="text-center opacity-0 translate-y-5 transition-all duration-500 ease-out animate-on-scroll delay-400">
            <a href="<?php echo esc_url( $button_link ); ?>" class="btn secondary-inverse">
                <?php echo wp_kses_post( $button_text ); ?>
            </a>
        </div>
        <?php endif; ?>
    </div>
</section>