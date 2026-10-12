<?php
get_header();
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <?php
    // Render the page title using the page-title block if available
    if (function_exists('do_blocks')) {
        // You can use a reusable block or a pattern if you have one, or just output the block markup
        echo do_blocks('<!-- wp:suburbancm/page-title {"title":"' . esc_html__('Our Team', 'suburbancm') . '", "subtitle":"Building lasting relationships through quality construction and expert management since 2020"} /-->');
    } else {
        echo '<h1 class="text-3xl font-bold text-center text-brand-text-light dark:text-white">' . esc_html__('Our Team', 'suburbancm') . '</h1>';
    }
    ?>
</div>

<section id="team" class="wp-block-suburbancm-team relative z-1 w-full flex items-center justify-center text-center py-20 pt-0 px-4 sm:px-6 lg:px-8 z-10  bg-[#1f1f1f] text-[#e4d198] antialiased opacity-0 transition-opacity duration-700 ease-out animate-on-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="team grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-8">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="team-member bg-brand-bg-light dark:bg-[#2a2a2a] p-6 rounded-lg shadow-md text-center opacity-0 scale-95 animate-on-scroll hover:-translate-y-1 transition-all duration-300">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="team-member-image w-32 h-32 rounded-full mx-auto mb-4 border-4 border-gold overflow-hidden">
                            <?php the_post_thumbnail('medium', ['class' => 'h-full w-full object-cover']); ?>
                        </div>
                    <?php endif; ?>
                    <h3 class="text-xl font-semibold mb-1 text-brand-text-light dark:text-white">
                        <?php the_title(); ?>
                    </h3>
                    <?php if ($role = get_field('role')): ?>
                        <p class="text-brand-accent dark:text-brand-text-dark font-medium mb-2">
                            <?php echo wp_kses_post($role); ?>
                        </p>
                    <?php endif; ?>
                    <p class="text-sm text-brand-text-muted-light dark:text-brand-text-muted-dark">
                        <?php echo wp_kses_post(get_the_excerpt()); ?>
                    </p>
                    <a href="<?php the_permalink(); ?>" class="inline-block mt-4 text-[#a38f50] dark:text-[#e4d198] hover:underline font-semibold">
                        <?php esc_html_e('View Profile', 'suburbancm'); ?>
                    </a>
                </div>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>