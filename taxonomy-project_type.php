<?php get_header(); ?>

<!-- PROJECTS HERO SECTION -->
<section id="projects-hero" class="bg-gradient-to-br from-brand-bg-light to-brand-bg-dark dark:from-brand-bg-alt-dark dark:to-brand-bg-dark flex items-center justify-center text-center py-24 px-4 sm:px-6 lg:px-8 min-h-[40vh]">
    <div class="max-w-3xl">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-white leading-tight opacity-0 translate-y-4 transition-all duration-700 ease-out" data-animate-on-load>
            Our <span class="text-brand-accent dark:text-brand-text-dark">Project Portfolio</span>
        </h1>
        <p class="mt-4 text-lg sm:text-xl text-brand-text-secondary-light dark:text-brand-text-dark/80 max-w-2xl mx-auto opacity-0 translate-y-4 transition-all duration-700 ease-out delay-200" data-animate-on-load>
            Explore a selection of our successfully completed projects across various sectors.
        </p>
    </div>
</section>

<!-- PROJECT FILTERS -->
<section id="project-filters" class="py-8 bg-brand-bg-alt-light dark:bg-brand-bg-alt-dark">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-sm font-semibold text-brand-text-secondary-light dark:text-brand-text-dark/80 mr-4">Filter by Category:</span>
        <div class="inline-flex flex-wrap justify-center gap-2 mt-2 sm:mt-0">
            <?php
            $categories = get_terms([
                'taxonomy'   => 'project_type',
                'hide_empty' => true,
            ]);
            $current_term = get_queried_object();
            $all_projects_active = !$current_term || !isset($current_term->term_id);
            $all_projects_classes = $all_projects_active
                ? 'bg-brand-accent text-white dark:bg-brand-text-dark dark:text-medium-gold border border-medium-gold shadow-lg hover:shadow-xl'
                : 'bg-brand-bg-light dark:bg-[#00000] text-brand-accent border border-brand-accent hover:bg-brand-accent hover:text-white hover:shadow-lg dark:hover:bg-brand-text-dark dark:hover:text-medium-gold';
            ?>
            <a href="<?php echo get_post_type_archive_link('projects'); ?>" class="px-4 py-1.5 rounded-md text-sm font-medium <?php echo $all_projects_classes; ?> transition-colors duration-150 ease-in-out">All Projects</a>
            <?php
            if (!empty($categories) && !is_wp_error($categories)) :
                foreach ($categories as $category) :
                    $is_active = ($current_term && $current_term->term_id === $category->term_id);
                    $active_classes = $is_active
                        ? 'bg-brand-accent text-white dark:bg-brand-text-dark dark:text-medium-gold border border-medium-gold shadow-lg hover:shadow-xl'
                        : 'bg-brand-bg-light dark:bg-[#00000] text-brand-accent border border-brand-accent hover:bg-brand-accent hover:text-white hover:shadow-lg dark:hover:bg-brand-text-dark dark:hover:text-medium-gold';
                ?>
                    <a href="<?php echo esc_url(get_term_link($category)); ?>" class="px-4 py-1.5 rounded-md text-sm font-medium <?php echo $active_classes; ?> transition-colors duration-150 ease-in-out">
                        <?php echo esc_html($category->name); ?>
                    </a>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>

<!-- PROJECTS GRID -->
<section id="projects-grid" class="py-16 lg:py-24 bg-brand-bg-light dark:bg-brand-bg-dark overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="sr-only">Project List</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <div class="flex flex-col bg-brand-bg-alt-light dark:bg-brand-bg-alt-dark rounded-lg shadow-md dark:shadow-gray-800 overflow-hidden group border-2 border-medium-gold hover:shadow-xl transition-all duration-300 ease-in-out opacity-0 scale-95 animate-on-scroll hover:-translate-y-1">
                        <div class="overflow-hidden">
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out">
                            <?php else : ?>
                                <img src="https://via.placeholder.com/600x400" alt="Placeholder" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out">
                            <?php endif; ?>
                        </div>
                        <div class="p-6 flex-1 flex flex-col mt-6">
                            <?php
                            $terms = get_the_terms(get_the_ID(), 'project_type');
                            if (!empty($terms) && !is_wp_error($terms)) : ?>
                                <p class="text-xs uppercase tracking-wider text-brand-text-muted-light dark:text-brand-text-muted-dark mb-1">
                                    <?php echo esc_html($terms[0]->name); ?>
                                </p>
                            <?php endif; ?>
                            <h3 class="text-xl font-semibold mb-2 text-brand-text-light dark:text-white"><?php the_title(); ?></h3>
                            <?php
                            $subtitle = '';
                            $blocks = parse_blocks(get_the_content());
                            foreach ($blocks as $block) {
                                if ($block['blockName'] === 'suburbancm/project-page' && !empty($block['attrs']['shortDescription'])) {
                                    $subtitle = apply_filters('the_content', $block['attrs']['shortDescription']);
                                    break;
                                }
                            }
                            if (empty($subtitle)) {
                                $subtitle = apply_filters('the_content', get_post_meta(get_the_ID(), '_wp_projects_shortDescription', true));
                            }
                            if (!empty($subtitle)) {
                                echo '<p class="text-brand-text-secondary-light dark:text-brand-text-dark/80 mb-4 text-sm">' . $subtitle . '</p>';
                            }
                            ?>
                            <div class="flex mt-6 h-full grow flex-col justify-end">
                                <a href="<?php the_permalink(); ?>" class="inline-block w-full text-center px-6 py-3 rounded-lg border-2 border-medium-gold text-medium-gold bg-transparent font-semibold text-base shadow-lg hover:bg-medium-gold hover:text-white transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-medium-gold focus:ring-offset-2">View Details &rarr;</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <p class="text-center text-brand-text-secondary-light dark:text-brand-text-dark/80">No projects found.</p>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <nav class="mt-16 flex items-center justify-center pt-8 opacity-0 animate-on-scroll" aria-label="Pagination">
            <?php
            the_posts_pagination([
                'mid_size'  => 2,
                'prev_text' => __('Previous', 'suburban'),
                'next_text' => __('Next', 'suburban'),
                'screen_reader_text' => __('Projects navigation', 'suburban'),
            ]);
            ?>
        </nav>
    </div>
</section>

<!-- CTA SECTION -->
<section id="cta-projects" class="bg-brand-accent text-white dark:bg-brand-accent-hover opacity-0 transition-opacity duration-700 ease-out animate-on-scroll">
    <div class="max-w-4xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
            Inspired by Our Work?
        </h2>
        <p class="mt-4 text-lg leading-6 text-brand-text-secondary-light dark:text-brand-text-dark/80">
            Let's discuss how we can bring the same level of quality and expertise to your upcoming project.
        </p>
        <div class="mt-8">
            <a href="/contact" class="btn primary">
                Request a Consultation
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>