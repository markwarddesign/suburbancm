<?php
$selected_projects = isset($attributes['selectedProjects']) ? $attributes['selectedProjects'] : [];
$title = isset($attributes['title']) ? $attributes['title'] : __('Featured Projects', 'suburbancm');
$description = isset($attributes['description']) ? $attributes['description'] : '';
$buttonText = isset($attributes['buttonText']) ? $attributes['buttonText'] : '';
$buttonUrl = isset($attributes['buttonUrl']) ? $attributes['buttonUrl'] : '';

if (!empty($selected_projects)) :
    $args = [
        'post_type' => 'projects',
        'post__in'  => $selected_projects,
        'orderby'   => 'post__in',
    ];
    $query = new WP_Query($args);
    if ($query->have_posts()) : ?>
        <section id="projects" class="py-16 lg:py-24 bg-[#2a2a2a] overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Title -->
                <h2 class="text-3xl font-bold text-center text-[#ffffff] mb-4 opacity-0 transition-opacity duration-700 ease-out animate-on-scroll ">
                    <?php echo wp_kses_post($title); ?>
                </h2>

                <!-- Description -->
                <?php if (!empty($description)) : ?>
                    <p class="text-center text-[#e4d198]/80 mb-12">
                        <?php echo wp_kses_post($description); ?>
                    </p>
                <?php endif; ?>

                <!-- Projects Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="bg-[#1f1f1f] rounded-lg shadow-md overflow-hidden group border border-[#80703a]/50 hover:shadow-xl transition-all opacity-0 transition-opacity duration-700 ease-out animate-on-scroll ">
                            <div class="overflow-hidden">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out">
                                <?php endif; ?>
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-semibold mb-2 text-[#ffffff]"><?php the_title(); ?></h3>
                                <p class="text-[#e4d198]/80 mb-4 text-sm"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                <a href="<?php the_permalink(); ?>" class="text-[#a38f50] hover:text-[#ffffff] font-medium text-sm relative after:absolute after:bg-[#e4d198] after:bottom-0 after:left-0 after:h-px after:w-full after:scale-x-0 after:origin-left hover:after:scale-x-100 after:transition-transform after:duration-300 after:ease-out">
                                    <?php esc_html_e('View Details →', 'suburbancm'); ?>
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- View All Button -->
                <?php if (!empty($buttonText) && !empty($buttonUrl)) : ?>
                    <div class="text-center mt-8">
                        <a href="<?php echo esc_url($buttonUrl); ?>" target="_blank" rel="noopener noreferrer" class="btn primary">
                            <?php echo wp_kses_post($buttonText); ?>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php endif;
endif;