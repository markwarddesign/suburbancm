<?php get_header(); ?>

<!-- BIDDING PROJECTS HERO SECTION -->
<section id="bidding-hero" class="bg-gradient-to-br from-brand-bg-light to-brand-border-light dark:from-brand-bg-alt-dark dark:to-brand-bg-dark flex items-center justify-center text-center py-24 px-4 sm:px-6 lg:px-8 min-h-[40vh]">
    <div class="max-w-3xl">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-white leading-tight opacity-0 translate-y-4 transition-all duration-700 ease-out" data-animate-on-load>
            Current <span class="text-brand-accent dark:text-brand-text-dark">Bidding Opportunities</span>
        </h1>
        <p class="mt-4 text-lg sm:text-xl text-brand-text-secondary-light dark:text-brand-text-dark/80 max-w-2xl mx-auto opacity-0 translate-y-4 transition-all duration-700 ease-out delay-200" data-animate-on-load>
            Explore our open bidding projects and submit your proposal.
        </p>
    </div>
</section>

<!-- PROJECTS GRID -->
<section id="projects-grid" class="py-16 lg:py-24 bg-brand-bg-light dark:bg-brand-bg-dark overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="sr-only">Bidding Project List</h2>
        <div class="grid grid-cols-1 gap-8">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    // Define published/updated/excerpt/subtitle before output
                    $published = get_the_date('F j, Y');
                    $updated = get_the_modified_date('F j, Y');
                    $excerpt = get_the_excerpt();
                    $subtitle = '';
                    $blocks = parse_blocks(get_the_content());
                    foreach ($blocks as $block) {
                        if ($block['blockName'] === 'suburbancm/bid-header' && !empty($block['attrs']['shortDescription'])) {
                            $subtitle = apply_filters('the_content', $block['attrs']['shortDescription']);
                            break;
                        }
                    }
                    if (empty($subtitle)) {
                        $subtitle = apply_filters('the_content', get_post_meta(get_the_ID(), '_wp_bidding_shortDescription', true));
                    }
                    ?>
                    <div class="border border-medium-gold rounded-xl shadow-lg p-0 w-full col-span-full flex flex-col md:flex-row overflow-hidden group hover:shadow-xl transition-all duration-300 ease-in-out opacity-0 scale-95 animate-on-scroll hover:-translate-y-1">
                        <div class="flex-1 p-8 flex flex-col justify-center">
                            <?php
                            $terms = get_the_terms(get_the_ID(), 'bidding_type');
                            if (!empty($terms) && !is_wp_error($terms)) :
                                ?>
                                <p class="text-xs uppercase tracking-wider text-medium-gold mb-2 font-bold">
                                    <?php echo esc_html($terms[0]->name); ?>
                                </p>
                            <?php endif; ?>
                            <h3 class="text-2xl font-extrabold mb-3 text-brand-text-light dark:text-white w-full leading-tight">
                                <a href="<?php the_permalink(); ?>" class="hover:text-medium-gold transition-colors duration-150">
                                    <?php the_title(); ?>
                                </a>
                            </h3>
                            <div class="mb-4 text-left flex gap-4 flex-wrap">
                                <span class="inline-flex items-center gap-2 px-0 py-0 rounded-lg bg-transparent text-medium-gold font-bold text-sm">
                                    <i class="fas fa-calendar-alt mr-2 text-lg flex-shrink-0" aria-hidden="true"></i>
                                    Published: <span class="font-normal text-sm"><?php echo esc_html($published); ?></span>
                                </span>
                                <span class="inline-flex items-center gap-2 px-0 py-0 rounded-lg bg-transparent text-brand-accent font-bold text-sm">
                                    <i class="fas fa-clock mr-2 text-lg flex-shrink-0" aria-hidden="true"></i>
                                    Updated: <span class="font-normal text-sm"><?php echo esc_html($updated); ?></span>
                                </span>
                                <?php 
                                $due_date = get_field('due_date');
                                if ($due_date) : ?>
                                    <span class="inline-flex items-center gap-2 px-2 py-1 rounded-lg bg-[#f6ecd9] text-[#7c5a00] font-bold text-sm">
                                        <i class="fas fa-calendar-day mr-2 text-lg flex-shrink-0" aria-hidden="true"></i>
                                        Due Date: <span class="font-normal text-sm"><?php echo esc_html(date('F j, Y', strtotime($due_date))); ?></span>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <?php
                            if (!empty($subtitle)) {
                                echo '<p class="text-brand-text-secondary-light dark:text-brand-text-dark/80 mb-4 text-base">' . $subtitle . '</p>';
                            }
                            if (!empty($excerpt)) {
                                echo '<p class="mb-4 text-base text-brand-text-light dark:text-brand-text-dark/80">' . esc_html($excerpt) . '</p>';
                            }
                            ?>
                            
                            <a href="<?php the_permalink(); ?>" class="mt-6 inline-block w-full md:w-auto text-center px-8 py-6 rounded-lg border-2 border-medium-gold text-medium-gold bg-brand-bg-alt-dark font-bold text-lg shadow-lg hover:bg-medium-gold hover:text-white transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-medium-gold focus:ring-offset-2">View Details &rarr;</a>

                        </div>
                    
                    
                    </div>
                <?php endwhile; ?>
            <?php else : ?>
                <div class="wp-block-group alignwide  has-background is-layout-constrained wp-block-group-is-layout-constrained"><div class="suburbancm-callout max-w-7xl mx-auto my-16 lg:mt-24 p-6 md:p-10 rounded-xl shadow-xl delay-100 border border-[#e4d198]/30 bg-[#a38f50]/20" style="opacity: 1; transform: translateY(0px);">
                    <div class="flex flex-col md:flex-row items-center md:items-start text-center md:text-left">
                        <div class="flex-shrink-0 mb-6 md:mb-0 md:mr-8 flex flex-col items-center">
                            <i class="fas fa-hard-hat" style="font-size:80px;color:#a38f50;background:#e4d198;border-radius:50%;width:128px;height:128px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px 0 rgba(0,0,0,0.18);margin-bottom:16px;" aria-hidden="true"></i>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-3xl md:text-4xl font-bold text-[#e4d198] mb-4">Check Back for Bidding Opportunities</h3>
                            <p class="text-lg text-[#e4d198]/90 mb-6 leading-relaxed">While there are no bidding opportunities posted right now, we are always looking for qualified contractors. Please check back frequently for updates.</p>
                        </div>
                    </div>
                </div></div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <nav class="mt-16 flex items-center justify-centerpt-8 opacity-0 animate-on-scroll" aria-label="Pagination">
            <?php
            the_posts_pagination([
                'mid_size'  => 2,
                'prev_text' => __('Previous', 'suburban'),
                'next_text' => __('Next', 'suburban'),
                'screen_reader_text' => __('Bidding navigation', 'suburban'),
            ]);
            ?>
        </nav>
    </div>
</section>

<!-- CTA SECTION -->
<section id="cta-bidding" class="bg-brand-accent text-white dark:bg-brand-accent-hover opacity-0 transition-opacity duration-700 ease-out animate-on-scroll">
    <div class="max-w-4xl mx-auto py-16 px-4 sm:px-6 lg:py-20 lg:px-8 text-center">
        <h2 class="text-3xl font-extrabold tracking-tight sm:text-4xl">
            Ready to Bid?
        </h2>
        <p class="mt-4 text-lg leading-6 text-brand-text-secondary-light dark:text-brand-text-dark/80">
            Submit your proposal or contact us for more information about current bidding opportunities.
        </p>
        <div class="mt-8">
            <a href="/contact" class="btn primary">
                Request Info
            </a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
