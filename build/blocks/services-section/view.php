<?php
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$services = $attributes['services'] ?? [];
?>

<section class="py-12 bg-[#1f1f1f] sm:py-16 lg:py-20 overflow-hidden wp-block-suburbancm-services-section">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 text-white py-20">
        <div class="text-center mb-12 mx-auto max-w-4xl opacity-0 transition-opacity duration-700 ease-out animate-on-scroll">
            <?php if ($title): ?>
                <h2 class="text-3xl font-bold tracking-tight text-white sm:text-4xl"><?php echo wp_kses_post($title); ?></h2>
            <?php endif; ?>
            <?php if ($description): ?>
                <p class="mt-4 text-lg text-[#e4d198]/80"><?php echo wp_kses_post($description); ?></p>
            <?php endif; ?>
        </div>
        <?php foreach ($services as $i => $service): ?>
            <?php
                // Alternate row direction for every other service
                $rowClass = ($i % 2 === 1)
                    ? 'flex-col md:flex-row-reverse'
                    : 'flex-col md:flex-row';
                // Optional: stagger animation delay
                $delayClass = 'delay-' . (($i + 1) * 100);
            ?>
            <div class="flex <?php echo $rowClass; ?> items-center bg-[#2a2a2a] rounded-lg shadow-xl overflow-hidden mb-12 opacity-0 translate-y-5 transition-all duration-500 ease-out animate-on-scroll <?php echo $delayClass; ?>">
                <div class="w-full md:w-1/3 flex-shrink-0 overflow-hidden relative">
                    <?php if (!empty($service['image'])): ?>
                        <img src="<?php echo esc_url($service['image']); ?>" alt="<?php echo esc_attr($service['alt'] ?? ''); ?>" class="w-full h-64 md:h-full object-cover" />
                    <?php endif; ?>
                </div>
                <div class="w-full md:w-2/3 p-6 md:p-8 flex-grow">
                    <?php if (!empty($service['title'])): ?>
                        <h3 class="text-2xl font-semibold text-white mb-3"><?php echo wp_kses_post($service['title']); ?></h3>
                    <?php endif; ?>
                    <?php if (!empty($service['description'])): ?>
                        <p class="text-gray-300 mb-5"><?php echo wp_kses_post($service['description']); ?></p>
                    <?php endif; ?>
                    <?php if (!empty($service['features']) && is_array($service['features'])): ?>
                        <div class="space-y-3">
                            <?php foreach ($service['features'] as $feature): ?>
                                <div class="flex items-center gap-2">
                                    <?php if (!empty($service['bulletIcon'])): ?>
                                        <!-- Font Awesome Icon -->
                                        <i class="far <?php echo $service['bulletIcon']; ?> text-[#80703a] mr-2"></i>
                                    <?php else: ?>
                                        <!-- Default Bullet Point -->
                                        <i class="far fa-circle-check text-[#80703a] mr-2"></i>
                                    <?php endif; ?>

                                    <span class="text-gray-300"><?php echo wp_kses_post($feature); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>