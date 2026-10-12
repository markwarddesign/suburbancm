<?php
/**
 * Register the "Team" Custom Post Type
 *
 * @package suburbancm
 */
$title = $attributes['title'] ?? '';
$showAll = $attributes['showAll'] ?? true;
$selectedTeamMembers = $attributes['selectedTeamMembers'] ?? [];

$args = [
    'post_type'      => 'team',
    'posts_per_page' => 100,
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
];

if (!$showAll && !empty($selectedTeamMembers)) {
    $args['post__in'] = $selectedTeamMembers;
    $args['orderby'] = 'post__in';
}

$query = new WP_Query($args);
?>

<section class="suburbancm-team relative z-1 w-full flex items-center justify-center text-center py-20 px-4 sm:px-6 lg:px-8 z-10 bg-[#1f1f1f] text-[#e4d198] antialiased">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (!empty($title) && !$attributes['hideTitle']) : ?>
            <h2 class="text-3xl font-bold text-center text-white mb-12"><?php echo wp_kses_post($title); ?></h2>
        <?php endif; ?>
        <div class="team grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-1 gap-8">
            <?php if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>
                <div class="team-member p-6 rounded-lg shadow-md text-center relative bg-[#2a2a2a]">
                    <div class="team-member-image w-32 h-32 rounded-full mx-auto mb-4 border-4 border-gold overflow-hidden">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', ['class' => 'h-full w-full object-cover']); ?>
                        <?php else : ?>
                            <img src="https://via.placeholder.com/300x300?text=Photo" alt="<?php the_title_attribute(); ?>" class="h-full w-full object-cover" />
                        <?php endif; ?>
                    </div>
                    <span class="text-white text-xl font-semibold mb-1 block"><?php the_title(); ?></span>
                    <?php if ($role = get_field('role')) : ?>
                        <span class="text-gold font-medium mb-2 block"><?php echo wp_kses_post($role); ?></span>
                    <?php endif; ?>
                    <?php if (get_the_excerpt()) : ?>
                        <span class="text-sm text-gold"><?php echo wp_kses_post(get_the_excerpt()); ?></span>
                    <?php endif; ?>
                    <div class="mt-4">
                        <a href="<?php the_permalink(); ?>" class="inline-block text-[#e4d198] hover:underline font-semibold">
                            <?php esc_html_e('View Profile', 'suburbancm'); ?>
                        </a>
                    </div>
                </div>
            <?php endwhile; else : ?>
                <p><?php esc_html_e('No team members to display.', 'suburbancm'); ?></p>
            <?php endif; wp_reset_postdata(); ?>
        </div>
    </div>
</section>