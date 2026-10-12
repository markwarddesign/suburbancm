<?php
$title = $attributes['title'] ?? '';
$buttonText = $attributes['buttonText'] ?? '';
$buttonUrl = $attributes['buttonUrl'] ?? '';
$hideBreadcrumb = !empty($attributes['hideBreadcrumb']);
?>
<section id="project-header" class="py-16 lg:pt-24 lg:pb-12 bg-brand-bg-alt-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="flex-1 min-w-0">
                <?php
                // Show breadcrumb only if not hidden and this is a child page
                global $post;
                if (!$hideBreadcrumb && $post && $post->post_parent) :
                    $parent = get_post($post->post_parent);
                    ?>
                    <nav class="flex mb-2" aria-label="Breadcrumb">
                        <ol role="list" class="flex items-center space-x-2">
                            <li>
                                <div>
                                    <a href="<?php echo esc_url(get_permalink($parent)); ?>" class="text-sm font-medium text-brand-text-muted-dark hover:text-brand-text-dark">
                                        <?php echo wp_kses_post(get_the_title($parent)); ?>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="ml-2 text-sm font-medium text-brand-text-muted-dark"><?php echo wp_kses_post(get_the_title()); ?></span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                <?php endif; ?>
                <?php if ($title): ?>
                    <h1 class="text-3xl font-bold leading-tight text-white sm:text-4xl sm:truncate">
                        <?php echo wp_kses_post($title); ?>
                    </h1>
                <?php endif; ?>
            </div>
            <?php if ($buttonText): ?>
                <div class="mt-5 flex lg:mt-0 lg:ml-4">
                    <a href="<?php echo esc_url($buttonUrl ?: '#'); ?>" class="btn primary inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-brand-accent hover:bg-brand-accent-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-accent transition duration-150 ease-in-out" target="_blank" rel="noopener noreferrer">
                        <?php echo wp_kses_post($buttonText); ?>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>