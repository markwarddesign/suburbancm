<?php
/**
 * Why Choose Us Block Template.
 *
 * @param array $attributes The block attributes.
 */

// Default attributes (useful if block.json defaults aren't fully hydrated, though usually they are)
$attributes = wp_parse_args(
    $attributes,
    [
        'heading'          => 'Building Trust, Delivering Excellence',
        'subheading'       => 'We bring expertise, integrity, and a commitment to quality to every project, ensuring your vision becomes a reality.',
        'features'         => [
            [
                'title'       => 'Proven Expertise',
                'description' => 'Decades of combined experience managing complex construction projects across diverse sectors.',
                'icon'        => 'info',
            ],
            [
                'title'       => 'Uncompromising Quality',
                'description' => 'Commitment to the highest standards of craftsmanship, materials, and safety protocols on every job site.',
                'icon'        => 'checkmark',
            ],
            [
                'title'       => 'Transparent Communication',
                'description' => 'Clear, consistent updates and a collaborative approach to keep you informed every step of the way.',
                'icon'        => 'clipboard',
            ],
        ],
        'buttonText'       => 'Request Your Consultation',
        'buttonLink'       => '#cta1',
        'align'            => '', // Ensure align attribute exists
    ]
);

$wrapper_attributes = get_block_wrapper_attributes(
    [
        'id'    => 'why-choose-us',
        'class' => 'mt-0 py-16 lg:py-24 bg-[#ffffff] dark:bg-[#2a2a2a] opacity-0 transition-opacity duration-700 ease-out animate-on-scroll overflow-hidden',
    ]
);

// Define SVGs - using a map for easier access
$icons = [
    'info' => '<svg class="w-8 h-8 text-[#a38f50] dark:text-[#e4d198]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" /></svg>',
    'checkmark' => '<svg class="w-8 h-8 text-[#a38f50] dark:text-[#e4d198]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>',
    'clipboard' => '<svg class="w-8 h-8 text-[#a38f50] dark:text-[#e4d198]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 20.25c4.97 0 9-3.694 9-8.25s-4.03-8.25-9-8.25S3 7.056 3 11.75c0 4.556 4.03 8.25 9 8.25Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-5.25 3h9" /></svg>',
];

?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <div class="max-w-7xl mx-auto px-6 lg:px-8">

        <div class="max-w-3xl mx-auto text-center mb-12 lg:mb-16">
            <h2 class="text-3xl font-extrabold text-[#000000] dark:text-white sm:text-4xl">
                <?php echo esc_html( $attributes['heading'] ); ?>
            </h2>
            <p class="mt-4 text-lg text-[#80703a] dark:text-[#e4d198]/80">
                <?php echo esc_html( $attributes['subheading'] ); ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12">
            <?php if ( ! empty( $attributes['features'] ) && is_array( $attributes['features'] ) ) : ?>
                <?php foreach ( $attributes['features'] as $index => $feature ) : ?>
                    <?php
                    $delay_class = 'delay-' . ( ( $index + 1 ) * 100 ); // delay-100, delay-200, delay-300
                    $icon_key    = isset( $feature['icon'] ) ? $feature['icon'] : 'info'; // Default to 'info' if not set
                    $icon_svg    = isset( $icons[ $icon_key ] ) ? $icons[ $icon_key ] : $icons['info']; // Fallback to info icon
                    ?>
                    <div class="text-center opacity-0 translate-y-5 transition-all duration-500 ease-out animate-on-scroll <?php echo esc_attr( $delay_class ); ?>">
                        <div class="inline-flex items-center justify-center p-3 bg-[#e4d198]/50 dark:bg-[#a38f50]/30 rounded-full mb-4">
                            <?php echo $icon_svg; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG is predefined and safe ?>
                        </div>
                        <h4 class="text-xl font-semibold text-[#000000] dark:text-white mb-2">
                            <?php echo esc_html( $feature['title'] ?? '' ); ?>
                        </h4>
                        <p class="text-sm text-[#80703a] dark:text-[#cccccc] leading-relaxed">
                            <?php echo esc_html( $feature['description'] ?? '' ); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="mt-16 text-center opacity-0 translate-y-5 transition-all duration-500 ease-out animate-on-scroll delay-400">
            <a href="<?php echo esc_url( $attributes['buttonLink'] ); ?>" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-[#a38f50] hover:bg-[#80703a] dark:text-[#1f1f1f] dark:bg-[#e4d198] dark:hover:bg-[#a38f50] dark:hover:text-white transition duration-200 ease-in-out transform hover:scale-105">
                <?php echo esc_html( $attributes['buttonText'] ); ?>
            </a>
        </div>
    </div>
</section>