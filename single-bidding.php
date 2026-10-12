<?php get_header(); ?>

<?php
// Setup header variables
$title = get_the_title();
$buttonText = get_post_meta(get_the_ID(), '_wp_bidding_cta_text', true);
$buttonUrl = get_post_meta(get_the_ID(), '_wp_bidding_cta_url', true);
$customBidUrl = get_field('custom_bid_url'); // Updated to use ACF field
$dueDate = get_field('due_date'); // Example usage of Due Date ACF field
$mailto = 'mailto:andrew@suburbancm.com?subject=' . rawurlencode('Bid Submission: ' . $title);
$submitBidUrl = $customBidUrl ? $customBidUrl : $mailto;
$submitBidTarget = $customBidUrl ? '_blank' : '';
$hideBreadcrumb = false;
?>
<section id="project-header" class="pt-16 pb-8" style="background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, #232323 100%);">
    <div class="max-w-7xl mx-auto px-6">
        <div class="lg:flex lg:items-center lg:justify-between">
            <div class="flex-1 min-w-0">
                <?php
                global $post;
                if (!$hideBreadcrumb && $post && $post->post_parent) :
                    $parent = get_post($post->post_parent);
                    ?>
                    <nav class="flex mb-2" aria-label="Breadcrumb">
                        <ol role="list" class="flex items-center space-x-2">
                            <li>
                                <div>
                                    <a href="<?php echo esc_url(get_permalink($parent)); ?>" class="text-sm font-medium text-brand-text-muted-dark hover:text-brand-text-dark">
                                        <?php echo esc_html(get_the_title($parent)); ?>
                                    </a>
                                </div>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="ml-2 text-sm font-medium text-brand-text-muted-dark"><?php echo esc_html(get_the_title()); ?></span>
                                </div>
                            </li>
                        </ol>
                    </nav>
                <?php endif; ?>
                <?php if ($dueDate): ?>
                    <div class="mb-4">
                        <span class="inline-flex items-center gap-2 px-2 py-1 rounded-lg bg-[#f6ecd9] text-[#7c5a00] font-bold text-sm">
                            <i class="fas fa-calendar-day mr-2 text-lg flex-shrink-0" aria-hidden="true"></i>
                            Due Date: <span class="font-normal text-sm"><?php echo esc_html(date('F j, Y', strtotime($dueDate))); ?></span>
                        </span>
                    </div>
                <?php endif; ?>
                <h1 class="text-3xl font-bold leading-tight text-white sm:text-4xl sm:truncate">
                    <?php echo esc_html($title); ?>
                </h1>
                <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-6 mt-2 mb-4 space-y-2 sm:space-y-0">
                    <span class="inline-flex items-center gap-2 px-0 py-0 rounded-lg bg-transparent text-medium-gold font-bold text-sm">
                        <i class="fas fa-calendar-alt mr-2 text-lg flex-shrink-0" aria-hidden="true"></i>
                        Published: <span class="font-normal text-sm"><?php echo esc_html(get_the_date('F j, Y')); ?></span>
                    </span>
                    <span class="inline-flex items-center gap-2 px-0 py-0 rounded-lg bg-transparent text-brand-accent font-bold text-sm">
                        <i class="fas fa-clock mr-2 text-lg flex-shrink-0" aria-hidden="true"></i>
                        Updated: <span class="font-normal text-sm"><?php echo esc_html(get_the_modified_date('F j, Y')); ?></span>
                    </span>
                </div>
            </div>
            <div class="mt-5 flex lg:mt-0 lg:ml-4">
                <a href="<?php echo esc_url($submitBidUrl); ?>" class="btn primary inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-brand-accent hover:bg-brand-accent-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-accent transition duration-150 ease-in-out"<?php if ($submitBidTarget) echo ' target="_blank" rel="noopener"'; ?>>
                    Submit Bid
                </a>
                <?php if ($buttonText): ?>
                    <a href="<?php echo esc_url($buttonUrl ?: '#'); ?>" class="btn primary inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-brand-accent hover:bg-brand-accent-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-accent transition duration-150 ease-in-out ml-4" target="_blank" rel="noopener noreferrer">
                        <?php echo esc_html($buttonText); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="py-16 pt-8 bg-brand-bg-light dark:bg-brand-bg-dark">
    <div class="max-w-7xl mx-auto px-6">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article <?php post_class('bg-brand-bg-alt-dark mb-12'); ?>>
                <div class="prose dark:prose-invert mb-8">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; endif; ?>
        <div class="mt-12 text-center">
            <a href="<?php echo esc_url($submitBidUrl); ?>" class="btn primary inline-flex items-center px-8 py-4 border border-transparent text-lg font-bold rounded-md shadow-sm text-white bg-brand-accent hover:bg-brand-accent-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-accent transition duration-150 ease-in-out"<?php if ($submitBidTarget) echo ' target="_blank" rel="noopener"'; ?>>
                Submit Your Bid
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
