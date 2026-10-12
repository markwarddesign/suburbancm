<?php
/**
 * PHP file to render the Hero Section block dynamically.
 *
 * @package BlockThemeStarter
 */

// Defaults ensure the block doesn't break if attributes are missing.
$heading_line1      = $attributes['headingLine1'] ?? 'Building Your Vision, ';
$heading_highlight  = $attributes['headingHighlight'] ?? 'Managing Every Detail';
$paragraph          = $attributes['paragraph'] ?? 'Expert construction management services ensuring your project is completed on time, within budget, and to the highest standards.';
$button1_text       = $attributes['button1Text'] ?? 'Request a Consultation';
$button1_link       = $attributes['button1Link'] ?? '#cta1';
$button2_text       = $attributes['button2Text'] ?? 'View Our Projects';
$button2_link       = $attributes['button2Link'] ?? '#projects';
$background_image_url = $attributes['backgroundImageUrl'] ?? '';

// --- Prepare Wrapper Attributes ---
$wrapper_attributes = get_block_wrapper_attributes(); // Base attributes (includes class, alignment etc.)
$style_attribute    = '';
$extra_classes = 'relative z-1 w-full flex items-center justify-center text-center py-20 px-4 sm:px-6 lg:px-8 z-10 bg-[#f6f5ec] text-[#000000] dark:bg-[#1f1f1f] dark:text-[#e4d198] antialiased'; // Updated classes

if ( ! empty( $background_image_url ) ) {
    // Add background image styles and classes
    $style_attribute = sprintf( 'style="background-image: url(%s); background-size: cover; background-position: center;"', esc_url( $background_image_url ) );
} else {
    // Add gradient styles if no background image

}

// Manually merge the extra classes into the wrapper attributes string
$wrapper_attributes = str_replace( 'class="', 'class="' . esc_attr( $extra_classes ) . ' ', $wrapper_attributes );


?>

<?php // Use the generated wrapper attributes for the section ?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
    <div class="absolute inset-0" <?php echo $style_attribute; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>></div>
    <div class="relative max-w-4xl mx-auto">

        <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-[#000000] dark:text-[#ffffff] leading-tight">
            <?php echo esc_html( $heading_line1 ); ?><span class="text-[#a38f50] dark:text-[#e4d198]"><?php echo esc_html( $heading_highlight ); ?></span>
        </h1>

        <?php if ( ! empty( $paragraph ) ) : ?>
            <p class="mt-4 text-lg sm:text-xl text-[#80703a] dark:text-[#e4d198]/80 max-w-2xl mx-auto">
                <?php echo esc_html( $paragraph ); ?>
            </p>
        <?php endif; ?>

        <div class="mt-8 flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
            <?php // Button 1 ?>
            <?php if ( ! empty( $button1_text ) && ! empty( $button1_link ) ) : ?>
                <a href="<?php echo esc_url( $button1_link ); ?>" class="button primary wp-block-suburbancm-hero-section-button1">
                    <?php echo esc_html( $button1_text ); ?>
                </a>
            <?php endif; ?>

            <?php // Button 2 ?>
            <?php if ( ! empty( $button2_text ) && ! empty( $button2_link ) ) : ?>
                <a href="<?php echo esc_url( $button2_link ); ?>" class="button secondary wp-block-suburbancm-hero-section-button2 inline-block bg-[#ffffff] text-[#a38f50] border border-[#e4d198] hover:bg-[#f6f5ec] dark:bg-[#444444] dark:text-[#e4d198] dark:border-[#80703a] dark:hover:bg-[#555555] px-8 py-3 rounded-md text-lg font-semibold transition duration-200 no-underline">
                    <?php echo esc_html( $button2_text ); ?>
                </a>
            <?php endif; ?>
        </div> <?php // .mt-8 flex... ?>

    </div> <?php // .relative max-w-4xl ?>
</section> <?php // End section with wrapper attributes ?>