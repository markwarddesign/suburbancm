<?php

$icon = $attributes['icon'] ?? 'fa-shield-alt';
$title = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$list = $attributes['list'] ?? [];
$afterText = $attributes['afterText'] ?? '';
?>
<div class="suburbancm-callout max-w-7xl mx-auto my-16 lg:mt-24 p-6 md:p-10 bg-[#a38f50]/20 rounded-xl shadow-xl animate-on-scroll delay-100 border border-[#e4d198]/30">
    <div class="flex flex-col md:flex-row items-center md:items-start text-center md:text-left">
        <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8 flex flex-col items-center">
            <i class="fas <?php echo esc_attr($icon); ?>"
               style="font-size:80px;color:#a38f50;background:#e4d198;border-radius:50%;width:128px;height:128px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px 0 rgba(0,0,0,0.18);margin-bottom:16px;"
               aria-hidden="true"></i>
        </div>
        <div class="flex-1">
            <?php if ($title): ?>
                <h3 class="text-3xl md:text-4xl font-bold text-[#e4d198] mb-4">
                    <?php echo wp_kses_post($title); ?>
                </h3>
            <?php endif; ?>
            <?php if ($description): ?>
                <p class="text-lg text-[#e4d198]/90 mb-6 leading-relaxed">
                    <?php echo wp_kses_post($description); ?>
                </p>
            <?php endif; ?>
            <?php if (!empty($list) && is_array($list)): ?>
                <ul class="space-y-3 text-md text-[#cccccc] leading-relaxed text-left">
                    <?php foreach ($list as $item): ?>
                        <li class="flex items-start">
                            <svg class="flex-shrink-0 h-5 w-5 text-[#e4d198] mr-2 mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" /></svg>
                            <span><?php echo wp_kses_post($item); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
            <?php if ($afterText): ?>
                <p class="mt-6 text-lg font-semibold text-[#e4d198] leading-relaxed">
                    <?php echo wp_kses_post($afterText); ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
</div>