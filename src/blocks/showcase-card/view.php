<?php
$image = $attributes['image'] ?? 'https://placehold.co/150x150/a38f50/ffffff/png?text=Local+Expertise';
$imageAlt = $attributes['imageAlt'] ?? 'Symbol of local commitment, e.g., Twin Falls landmark';
$title = $attributes['title'] ?? '';
$text = $attributes['text'] ?? '';
?>
<section id="showcase-card" class="py-16 lg:py-24 bg-[#1f1f1f]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto bg-[#2a2a2a] p-8 md:p-12 rounded-xl shadow-xl animate-on-scroll delay-100">
            <div class="flex flex-col lg:flex-row  text-center lg:text-left">
                <div class="flex-shrink-0 mb-6 lg:mb-0 lg:mr-10 self-start">
                    <img src="<?php echo esc_url($image); ?>"
                         alt="<?php echo esc_attr($imageAlt); ?>"
                         class="w-24 h-24 md:w-32 md:h-32 rounded-full object-contain shadow-md">
                </div>
                <div class="flex-1">
                    <?php if ($title) : ?>
                        <h2 class="text-3xl md:text-4xl font-semibold text-[#e4d198] mb-4">
                            <?php echo wp_kses_post($title); ?>
                        </h2>
                    <?php endif; ?>
                    <?php if ($text) : ?>
                        <p class="text-lg md:text-xl text-[#e4d198]/90 leading-relaxed">
                            <?php echo wp_kses_post($text); ?>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>