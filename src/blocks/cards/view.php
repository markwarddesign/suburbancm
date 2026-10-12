<?php
$title = $attributes['title'] ?? '';
$cards = $attributes['cards'] ?? [];
?>

<div class="opacity-0 translate-y-5 transition-all duration-500 ease-out animate-on-scroll">
    <?php if (!empty($title)) : ?>
        <h3 class="text-2xl font-semibold text-[#e4d198] mb-6 text-center md:text-left">
            <?php echo wp_kses_post($title); ?>
        </h3>
    <?php endif; ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php foreach ($cards as $i => $card) : 
            // Stagger delay: 0.1s per card
            $delay = 0.1 * $i;
        ?>
            <div
                class="bg-[#1f1f1f] p-6 rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300"
                style="transition-delay: <?php echo $delay; ?>s;"
            >
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-[#a38f50]/20 mb-4">
                    <?php if (!empty($card['icon'])) : ?>
                        <i class="<?php echo esc_attr($card['icon']); ?> text-[#e4d198]" aria-hidden="true"></i>
                    <?php endif; ?>
                </div>
                <?php if (!empty($card['cardTitle'])) : ?>
                    <h4 class="text-xl font-semibold text-[#fff] mb-2">
                        <?php echo wp_kses_post($card['cardTitle']); ?>
                    </h4>
                <?php endif; ?>
                <?php if (!empty($card['description'])) : ?>
                    <p class="text-sm text-[#cccccc] leading-relaxed">
                        <?php echo wp_kses_post($card['description']); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>