<?php
$image = $attributes['image'] ?? 'https://placehold.co/600x450/e4d198/80703a/png?text=Collaborative+Planning';
$imageAlt = $attributes['imageAlt'] ?? 'Team collaborating on project plans';
$text = $attributes['text'] ?? '';
?>
<section id="image-text-intro" class="py-16 lg:py-20 bg-[#2a2a2a]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 animate-on-scroll">
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <div class="md:w-2/5 flex-shrink-0">
                <img src="<?php echo esc_url($image); ?>"
                     alt="<?php echo esc_attr($imageAlt); ?>"
                     class="w-full h-auto rounded-xl shadow-lg object-cover">
            </div>
            <div class="md:w-3/5 text-center md:text-left">
                <p class="text-xl md:text-2xl text-[#e4d198] leading-relaxed font-normal">
                    <?php echo wp_kses_post($text); ?>
                </p>
                <hr class="mt-8 border-t border-[#e4d198]/30 w-24 mx-auto md:mx-0">
            </div>
        </div>
    </div>
</section>