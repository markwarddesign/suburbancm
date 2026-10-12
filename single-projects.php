<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>



<!-- Main Content - Rendered by Gutenberg -->
<article class="py-16 lg:py-16 bg-brand-bg-alt-dark">

    <!-- PROJECT HEADER -->
    <section id="project-header" class="bg-brand-bg-alt-dark">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:items-center lg:justify-between mb-16">
                <div class="flex-1 min-w-0">
                    <nav class="flex mb-2" aria-label="Breadcrumb">
                        <ol role="list" class="flex items-center space-x-2">
                            <li>
                                <div>
                                    <a href="/projects/" class="text-sm font-medium text-brand-text-muted-dark hover:text-brand-text-dark">Projects</a>
                                </div>
                            </li>
                            <?php
                            $terms = get_the_terms(get_the_ID(), 'project_type');
                            if ($terms && !is_wp_error($terms)) {
                                $term = $terms[0];
                                ?>
                                <li>
                                    <div class="flex items-center">
                                        <svg class="flex-shrink-0 h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="ml-2 text-sm font-medium text-brand-text-muted-dark"><?php echo esc_html($term->name); ?></span>
                                    </div>
                                </li>
                            <?php } ?>
                        </ol>
                    </nav>
                    <h1 class="text-3xl font-bold leading-tight text-white sm:text-4xl sm:truncate"><?php the_title(); ?></h1>
                </div>
                <div class="mt-5 flex lg:mt-0 lg:ml-4">
                    <a href="/contact" class="btn primary inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-brand-accent hover:bg-brand-accent-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-accent transition duration-150 ease-in-out">
                        Start Your Project
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto pb-16 sm:px-6 lg:px-8">
        <?php the_content(); ?>
    </div>
</article>

<?php
$terms = get_the_terms(get_the_ID(), 'project_type');
if ($terms && !is_wp_error($terms)) {
    $term_ids = wp_list_pluck($terms, 'term_id');
    $related_args = [
        'post_type' => 'projects',
        'posts_per_page' => 3,
        'post__not_in' => [get_the_ID()],
        'tax_query' => [
            [
                'taxonomy' => 'project_type',
                'field'    => 'term_id',
                'terms'    => $term_ids,
            ],
        ],
    ];
    $related_query = new WP_Query($related_args);
    if ($related_query->have_posts()) : ?>
        <section id="related-projects" class="bg-brand-bg-light dark:bg-brand-bg-dark py-16">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-bold mb-8 text-brand-text-dark dark:text-white">Related Projects</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                        <div class="flex flex-col bg-brand-bg-alt-light dark:bg-brand-bg-alt-dark rounded-lg shadow-md border-2 border-medium-gold overflow-hidden group hover:shadow-xl transition-all duration-300 ease-in-out">
                            <div class="overflow-hidden">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img src="<?php echo esc_url(the_post_thumbnail_url('medium')); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out" />
                                <?php else : ?>
                                    <img src="https://via.placeholder.com/600x400" alt="Placeholder" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300 ease-in-out" />
                                <?php endif; ?>
                            </div>
                            <div class="p-6 flex-1 flex flex-col mt-6">
                                <h3 class="text-xl font-semibold mb-2 text-brand-text-light dark:text-white"><?php the_title(); ?></h3>
                                <div class="flex mt-6 h-full grow flex-col justify-end">
                                    <a href="<?php the_permalink(); ?>" class="inline-block w-full text-center px-6 py-3 rounded-lg border-2 border-medium-gold text-medium-gold bg-transparent font-semibold text-base shadow-lg hover:bg-medium-gold hover:text-white transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-medium-gold focus:ring-offset-2">View Details →</a>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </section>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <?php error_log('No related projects found. Args: ' . print_r($related_args, true)); ?>
    <?php endif; ?>
<?php } else {
    error_log('No terms found or taxonomy error for post ID: ' . get_the_ID());
} ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>