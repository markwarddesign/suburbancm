<?php
$title = $attributes['title'] ?? '';
$testimonials = $attributes['testimonials'] ?? [];
?>

<section id="slider-section" class="py-16 lg:py-24 bg-[#1f1f1f] opacity-0 transition-opacity duration-700 ease-out animate-on-scroll">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if ($title): ?>
            <h2 class="text-3xl font-bold text-center text-[#e4d198] mb-12">
                <?php echo wp_kses_post($title); ?>
            </h2>
        <?php endif; ?>
        <div class="relative overflow-hidden rounded-lg">
            <div id="slider-track" class="flex slider-track">
                <?php foreach ($testimonials as $testimonial): ?>
                    <div class="w-full flex-shrink-0 px-2 sm:px-4">
                        <div class="bg-[#2a2a2a] p-8 rounded-lg shadow-md shadow-gray-700 text-center h-full flex flex-col justify-center">
                            <?php if (!empty($testimonial['image'])): ?>
                                <img
                                    src="<?php echo esc_url($testimonial['image']); ?>"
                                    alt="<?php echo esc_attr($testimonial['alt']); ?>"
                                    class="w-20 h-20 rounded-full mx-auto mb-4 border-2 border-[#e4d198]"
                                />
                            <?php endif; ?>
                            <?php if (!empty($testimonial['quote'])): ?>
                                <p class="text-[#e4d198]/80 italic mb-4">
                                    <?php echo wp_kses_post($testimonial['quote']); ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($testimonial['name'])): ?>
                                <p class="font-semibold text-[#e4d198]">
                                    <?php echo wp_kses_post($testimonial['name']); ?>
                                </p>
                            <?php endif; ?>
                            <?php if (!empty($testimonial['role'])): ?>
                                <p class="text-sm text-[#e4d198]/70">
                                    <?php echo wp_kses_post($testimonial['role']); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button id="slider-prev" class="absolute top-1/2 left-1 transform -translate-y-1/2 bg-[#1f1f1f]/70 hover:bg-[#2a2a2a] p-2 rounded-full shadow-md text-[#e4d198] hover:text-[#ffffff] focus:outline-none z-10 transition-colors duration-200 ease-in-out">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            <button id="slider-next" class="absolute top-1/2 right-1 transform -translate-y-1/2 bg-[#1f1f1f]/70 hover:bg-[#2a2a2a] p-2 rounded-full shadow-md text-[#e4d198] hover:text-[#ffffff] focus:outline-none z-10 transition-colors duration-200 ease-in-out">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <div id="slider-dots" class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2"></div>
        </div>
    </div>
</section>