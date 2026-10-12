<?php
$phases = $attributes['phases'] ?? [];
?>
<section id="phases" class="pb-16 lg:pb-24 bg-[#2a2a2a]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="space-y-16">
            <?php foreach ($phases as $idx => $phase): ?>
                <div class="p-6 md:p-8 bg-[#1f1f1f] rounded-xl shadow-lg animate-on-scroll delay-<?php echo 100 + $idx * 100; ?> mb-7npm">
                    <?php if (!empty($phase['image'])): ?>
                        <img src="<?php echo esc_url($phase['image']); ?>"
                             alt="<?php echo esc_attr($phase['imageAlt'] ?? 'Phase image'); ?>"
                             class="w-full h-48 object-cover rounded-lg mb-6 shadow-md">
                    <?php endif; ?>
                    <?php if (!empty($phase['title'])): ?>
                        <h3 class="text-2xl md:text-3xl font-semibold text-[#e4d198] mb-3">
                            <span class="text-sm uppercase tracking-wider block text-[#a38f50]/70 mb-1">
                                <?php echo wp_kses_post($phase['title']); ?>
                            </span>
                            <?php echo !empty($phase['subtitle']) ? wp_kses_post($phase['subtitle']) : ''; ?>
                        </h3>
                    <?php endif; ?>
                    <?php if (!empty($phase['description'])): ?>
                        <p class="text-lg text-[#e4d198]/80 mb-8 leading-relaxed">
                            <?php echo wp_kses_post($phase['description']); ?>
                        </p>
                    <?php endif; ?>
                    <?php if (!empty($phase['steps'])): ?>
                        <div class="space-y-6">
                            <?php foreach ($phase['steps'] as $step): ?>
                                <div class="bg-[#2a2a2a] p-6 rounded-lg shadow-md">
                                    <?php if (!empty($step['heading'])): ?>
                                        <h4 class="text-xl font-semibold text-white mb-2">
                                            <?php echo wp_kses_post($step['heading']); ?>
                                        </h4>
                                    <?php endif; ?>
                                    <?php
                                    // Handle both string and array for text, and check isList
                                    if (!empty($step['isList']) && is_array($step['text'])): ?>
                                        <ul class="list-disc pl-6 text-md text-[#cccccc] leading-relaxed marker:text-medium-gold">
                                            <?php foreach ($step['text'] as $item): if (trim($item) !== ''): ?>
                                                <li class="text-[#cccccc]"><?php echo wp_kses_post($item); ?></li>
                                            <?php endif; endforeach; ?>
                                        </ul>
                                    <?php elseif (is_array($step['text'])): ?>
                                        <ul class="pl-6 text-md text-[#cccccc] leading-relaxed ml-4">
                                            <?php foreach ($step['text'] as $item): if (trim($item) !== ''): ?>
                                                <li><?php echo wp_kses_post($item); ?></li>
                                            <?php endif; endforeach; ?>
                                        </ul>
                                    <?php elseif (!empty($step['text'])): ?>
                                        <p class="text-md text-[#cccccc] leading-relaxed">
                                            <?php echo wp_kses_post($step['text']); ?>
                                        </p>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>