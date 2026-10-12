<?php get_header(); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <a href="/team" class="text-sm text-[#e4d198] hover:underline">&larr; Back to Our Team</a>
</div>

<section id="team-member-profile" class="py-12 md:py-20 bg-[#1f1f1f] opacity-0 transition-opacity duration-700 ease-out animate-on-scroll">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 lg:gap-12 items-start">
                <div class="md:col-span-1 space-y-6 opacity-0 translate-y-5 transition-all duration-500 ease-out animate-on-scroll">
                    <div class="team-member-image-large relative group shadow-lg">
                        <?php if (has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('large', ['class' => 'w-full h-auto object-cover rounded-lg border-4 border-gold']); ?>
                        <?php else: ?>
                            <img src="https://via.placeholder.com/600x600.png?text=Team+Member+Photo" alt="<?php the_title_attribute(); ?>" class="w-full h-auto object-cover rounded-lg border-4 border-gold">
                        <?php endif; ?>
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl lg:text-4xl font-bold text-white mb-1"><?php the_title(); ?></h1>
                        <?php if ($role = get_field('role')): ?>
                            <p class="text-xl text-[#e4d198] font-medium mb-4"><?php echo esc_html($role); ?></p>
                        <?php endif; ?>
                        <div class="flex justify-center md:justify-start space-x-4">
                            <?php if ($linkedin = get_field('linkedin')): ?>
                                <a href="<?php echo esc_url($linkedin); ?>" aria-label="<?php the_title_attribute(); ?> on LinkedIn" class=" text-gray-400 hover:text-[#e4d198] transition-colors duration-150" target="_blank" rel="noopener">
                                    <i class="fab fa-linkedin fa-2x"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($twitter = get_field('twitter')): ?>
                                <a href="<?php echo esc_url($twitter); ?>" aria-label="<?php the_title_attribute(); ?> on Twitter" class="text-gray-400 hover:text-[#e4d198] transition-colors duration-150" target="_blank" rel="noopener">
                                    <i class="fab fa-twitter fa-2x"></i>
                                </a>
                            <?php endif; ?>
                            <?php if ($email = get_field('email')): ?>
                                <a href="mailto:<?php echo antispambot($email); ?>" aria-label="Email <?php the_title_attribute(); ?>" class=" text-gray-400 hover:text-[#e4d198] transition-colors duration-150">
                                    <i class="fas fa-envelope fa-2x"></i>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2 opacity-0 translate-y-5 transition-all duration-500 ease-out animate-on-scroll delay-100">
                    <div class="bg-[#2a2a2a] p-6 sm:p-8 rounded-lg shadow-lg">
                        <h2 class="text-2xl font-semibold text-white mb-4">About <?php the_title(); ?></h2>
                        <div class="text-[#e4d198]/80 space-y-4 leading-relaxed">
                            <?php the_content(); ?>
                            <?php if ($skills = get_field('skills')): ?>
                                <h3 class="text-xl font-semibold text-white pt-4 mt-6 mb-2">Key Skills & Expertise</h3>
                                <ul class="list-disc list-inside space-y-1 text-[#e4d198]/80">
                                    <?php foreach ($skills as $skill): ?>
                                        <li><?php echo esc_html($skill['skill']); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                            <?php if ($personal_note = get_field('personal_note')): ?>
                                <h3 class="text-xl font-semibold text-white pt-4 mt-6 mb-2">Personal Note</h3>
                                <p><?php echo esc_html($personal_note); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; endif; ?>
    </div>
</section>

<?php
$related_projects = get_field('related_projects');
if ($related_projects):
?>
    <section id="team-member-projects" class="py-12 md:py-20 bg-[#2a2a2a] opacity-0 transition-opacity duration-700 ease-out animate-on-scroll delay-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="text-3xl font-bold text-center text-white mb-12">
                Key Projects Involving <?php the_title(); ?>
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php foreach ($related_projects as $post): setup_postdata($post); ?>
                    <a href="<?php the_permalink(); ?>" class="block group transition-all duration-200 ease-in-out hover:scale-[1.02] opacity-0 translate-y-5 animate-on-scroll delay-300">
                        <div class="bg-[#333333] rounded-lg overflow-hidden shadow-md group-hover:shadow-xl h-full flex flex-col">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('medium', ['class' => 'w-full h-48 object-cover']); ?>
                            <?php endif; ?>
                            <div class="p-4 flex-grow">
                                <p class="font-semibold text-md text-white group-hover:text-[#e4d198]">
                                    <?php the_title(); ?>
                                </p>
                                <?php if ($type = get_field('project_type')): ?>
                                    <p class="text-sm text-gray-400 mt-1">
                                        <?php echo esc_html($type); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </a>
                <?php endforeach; wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php get_footer(); ?>