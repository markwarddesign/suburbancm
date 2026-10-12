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
$extra_classes      = 'min-h-[calc(100vh-4rem)] flex items-center justify-center text-center py-20 px-4 sm:px-6 lg:px-8 z-10'; // Common classes

if ( ! empty( $background_image_url ) ) {
	// Add background image styles and classes
	$style_attribute = sprintf( 'style="background-image: url(%s);"', esc_url( $background_image_url ) );
	$extra_classes  .= ' bg-cover bg-center'; // Add positioning classes
} else {
	// Add gradient classes if no background image
	$extra_classes .= ' bg-gradient-to-br from-[#f6f5ec] to-[#e4d198] dark:from-[#2a2a2a] dark:to-[#1f1f1f]';
}

// Manually merge the style and extra classes into the wrapper attributes string
// This is a bit manual because get_block_wrapper_attributes doesn't have built-in style merging yet in quite this way
$wrapper_attributes = str_replace( 'class="', 'class="' . esc_attr( $extra_classes ) . ' ', $wrapper_attributes );
if ( ! empty( $style_attribute ) ) {
	// Inject the style attribute before the closing >
	$wrapper_attributes = rtrim( $wrapper_attributes, '>' ) . ' ' . $style_attribute . '>';
}

// Add the ID if needed - though static IDs on blocks are less common in dynamic rendering
// If you absolutely need the #hero ID, you could add it here, but consider if it's necessary.
// $wrapper_attributes = str_replace('class="', 'id="hero" class="', $wrapper_attributes);

?>

<?php // Use the generated wrapper attributes for the section ?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="max-w-4xl">

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
				<a href="<?php echo esc_url( $button1_link ); ?>" class="wp-block-itsamoreh-hero-section-button1 inline-block bg-[#a38f50] text-[#ffffff] hover:bg-[#80703a] dark:bg-[#a38f50] dark:hover:bg-[#e4d198] dark:text-[#1f1f1f] dark:hover:text-[#1f1f1f] px-8 py-3 rounded-md text-lg font-semibold transition duration-200">
					<?php echo esc_html( $button1_text ); ?>
				</a>
			<?php endif; ?>

			<?php // Button 2 ?>
			<?php if ( ! empty( $button2_text ) && ! empty( $button2_link ) ) : ?>
				<a href="<?php echo esc_url( $button2_link ); ?>" class="wp-block-itsamoreh-hero-section-button2 inline-block bg-[#ffffff] text-[#a38f50] border border-[#e4d198] hover:bg-[#f6f5ec] dark:bg-[#444444] dark:text-[#e4d198] dark:border-[#80703a] dark:hover:bg-[#555555] px-8 py-3 rounded-md text-lg font-semibold transition duration-200">
					<?php echo esc_html( $button2_text ); ?>
				</a>
			<?php endif; ?>
		</div> <?php // .mt-8 flex... ?>

	</div> <?php // .max-w-4xl ?>
</section> <?php // End section with wrapper attributes ?>