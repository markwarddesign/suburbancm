<?php
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$level = isset($attributes['level']) ? intval($attributes['level']) : 2;
$level = ($level >= 1 && $level <= 5) ? $level : 2;
$align = $attributes['align'] ?? 'center';
$HeadingTag = "h{$level}";
$hideTitle = $attributes['hideTitle'] ?? false;

// Tailwind alignment class
$alignClass = '';
if (in_array($align, ['left', 'center', 'right', 'justify'])) {
    $alignClass = 'text-' . $align;
}
?>

<div class="suburbancm-section-title mb-12 lg:mb-16">
    <div class="suburbancm-section-title__content max-w-3xl mx-auto">
        <?php if ($title) : ?>
            <<?php echo esc_attr($HeadingTag); ?> class="suburbancm-section-title__title <?php echo esc_attr($alignClass); ?> text-[#e4d198]">
                <?php echo wp_kses_post($title); ?>
            </<?php echo esc_attr($HeadingTag); ?>>
        <?php endif; ?>
        <?php if ($description) : ?>
            <p class="suburbancm-section-title__description <?php echo esc_attr($alignClass); ?> text-[#cccccc]">
                <?php echo wp_kses_post($description); ?>
            </p>
        <?php endif; ?>
    </div>
</div>