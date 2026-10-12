<?php
/**
 * Bidding PDFs Block View
 *
 * @var array $attributes Block attributes, expects 'pdfs' => [ [ 'url' => ..., 'name' => ... ], ... ]
 */
$pdfs = isset($attributes['pdfs']) && is_array($attributes['pdfs']) ? $attributes['pdfs'] : [];
$title = !empty($attributes['blockTitle']) ? wp_kses_post($attributes['blockTitle']) : 'Downloads';
if (!empty($pdfs)) : ?>
  <div class="wp-block-bidding-pdfs bg-[#181818] border border-[#80703a] rounded-lg p-8 shadow-md my-6">
    <h3 class="text-2xl font-bold text-[#e4d198] mb-6 text-center"><?php echo $title; ?></h3>
    <ul class="flex flex-wrap gap-8 mb-6 mt-6 justify-center">
      <?php foreach ($pdfs as $pdf) :
        $url = esc_url($pdf['url'] ?? '');
        $name = wp_kses_post($pdf['name'] ?? basename($url));
        if ($url): ?>
          <li class="flex flex-col items-center w-40">
            <a href="<?php echo $url; ?>" class="flex flex-col items-center group" target="_blank" rel="noopener">
              <i class="fas fa-file-pdf text-5xl mb-3 text-[#e4d198] group-hover:text-[#a38f50]"></i>
              <span class="block text-center text-base text-white group-hover:text-[#e4d198]"><?php echo $name; ?></span>
            </a>
          </li>
        <?php endif; ?>
      <?php endforeach; ?>
    </ul>
  </div>
<?php else : ?>
  <p class="text-base text-[#e4d198]">No bidding documents available.</p>
<?php endif; ?>
