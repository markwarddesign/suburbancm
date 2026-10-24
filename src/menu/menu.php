<?php
// Navigation Menu
function suburban_register_menus() {
    register_nav_menus(
        array(
            'primary-menu' => __( 'Primary Menu', 'suburban' ),
            'footer-menu'  => __( 'Footer Menu', 'suburban' ),
            'social-menu'  => __( 'Social Menu', 'suburban' ),
            'mobile-menu'  => __( 'Mobile Menu', 'suburban' ),
            'privacy-menu' => __( 'Privacy Menu', 'suburban' ),
        )
    );
}
add_action( 'init', 'suburban_register_menus' );


class Suburban_Walker_Nav_Menu extends Walker_Nav_Menu {
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        // Only output sub-menu if not a mega menu
        $parent_classes = isset($args->walker->current_item_classes) ? $args->walker->current_item_classes : [];
        $is_mega = false;
        if (is_array($parent_classes)) {
            foreach ($parent_classes as $class) {
                if (strpos($class, 'mega-menu') !== false) {
                    $is_mega = true;
                    break;
                }
            }
        }
        if ($is_mega) {
            return; // Don't output regular sub-menu for mega menu items
        }
        $submenu_classes = 'sub-menu absolute left-0 top-full block md:hidden bg-[#2a2a2a] min-w-[200px] z-50 shadow-lg';
        $output .= "\n$indent<ul class=\"$submenu_classes\">\n";
    }

    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $parent_classes = isset($args->walker->current_item_classes) ? $args->walker->current_item_classes : [];
        $is_mega = false;
        if (is_array($parent_classes)) {
            foreach ($parent_classes as $class) {
                if (strpos($class, 'mega-menu') !== false) {
                    $is_mega = true;
                    break;
                }
            }
        }
        if ($is_mega) {
            return;
        }
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $classes = empty($item->classes) ? [] : (array) $item->classes;
        $has_children = in_array('menu-item-has-children', $classes);
        $is_mega_projects = in_array('mega-menu-projects', $classes);
    
        $is_mega_services = in_array('mega-menu-services', $classes);


        // Store current item's classes for use in start_lvl/end_lvl
        if (is_object($args)) {
            $args->walker->current_item_classes = $classes;
        }

        // --- SKIP: If this is a child (any depth) of a mega-menu-services item, don't render as a top-level item ---
        $menu_items = wp_get_nav_menu_items('primary-menu');
        $parent_is_mega_services = false;
        $parent_id = $item->menu_item_parent;
        while ($menu_items && $parent_id) {
            foreach ($menu_items as $nav_item) {
                if ((int)$nav_item->ID === (int)$parent_id) {
                    if (in_array('mega-menu-services', (array)$nav_item->classes)) {
                        $parent_is_mega_services = true;
                        break 2;
                    }
                    $parent_id = $nav_item->menu_item_parent;
                    break;
                }
            }
            // Prevent infinite loop
            if ($parent_id == $item->menu_item_parent) {
                break;
            }
        }
        if ($parent_is_mega_services) {
            return; // Don't render this item at the top level or anywhere in the main nav
        }
        // ----------------------------------------------------------------------

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $li_classes = 'flex h-full items-center';
        if ($has_children) $li_classes .= ' menu-item-has-children relative';
        if ($is_mega_projects) $li_classes .= ' mega-menu-projects';
        if ($is_mega_services) $li_classes .= ' mega-menu-services';
        
        if ($is_mega_services) {
            // remove 'menu-item-has-children' class if this is a mega menu item
            $li_classes = str_replace('menu-item-has-children relative', '', $li_classes);
        }

        $output .= '<li class="' . esc_attr($li_classes . ' ' . $class_names) . '">';

        // Data attributes for mega menus
        $data_attributes = '';
        if ($is_mega_projects) {
            $data_attributes = ' data-toggle="mega-menu" data-target="#projects-mega-menu"';
        } elseif ($is_mega_services) {
            $data_attributes = ' data-toggle="mega-menu" data-target="#services-mega-menu"';
        }

        // Dropdown icon
        $dropdown_icon = '';
        if ($is_mega_projects || $is_mega_services) {
            $dropdown_icon = '<span class="dropdown-icon ml-2"><i class="fas fa-chevron-down"></i></span>';
        } elseif ($has_children) {
            $dropdown_icon = '<span class="dropdown-icon ml-2"><i class="fas fa-chevron-down"></i></span>';
        }

        $output .= '<a href="' . esc_url($item->url) . '" class="menu-link flex h-full items-center"' . $data_attributes . '>' . esc_html($item->title) . $dropdown_icon . '</a>';

        // Inject mega menu HTML for specific menu items
        if ($is_mega_projects) {
            $output .= $this->get_projects_mega_menu();
        } elseif ($is_mega_services) {
            $output .= $this->get_services_mega_menu($item);
        }
    }

    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= '</li>';
    }


    private function get_projects_mega_menu() {
        ob_start();
    
        // Get project categories
        $categories = get_terms([
            'taxonomy'   => 'project_type', // Replace with your custom taxonomy if applicable
            'hide_empty' => true,
        ]);
    
        // Query featured projects
        $featured_projects = new WP_Query([
            'post_type'      => 'projects', // Replace with your custom post type slug
            'posts_per_page' => 2, // Number of featured projects to display
            // 'meta_key'       => 'is_featured', // Replace with your custom meta key for featured posts
            // 'meta_value'     => '1', // Value indicating a featured post
        ]);
        ?>
        <div id="projects-mega-menu" class="absolute left-0 w-full z-30 border-y border-gray-700 bg-[#2a2a2a] shadow-2xl transition-transform duration-300 ease-in-out hidden" style="top:100%;padding-top:2rem;padding-bottom:2rem;box-shadow:0 12px 48px 0 rgba(0,0,0,0.25);">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6 px-6 py-5 text-sm">
                <div class="md:col-span-1">
                    <p class="font-semibold uppercase tracking-wider text-[#e4d198] mb-3">Project Types</p>
                    <ul class="space-y-3">
                        <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                            <?php foreach ($categories as $category) : ?>
                                <li>
                                    <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="block p-1 rounded  text-[#cccccc] hover:text-[#e4d198] hover:bg-[#444444] transition-colors duration-150">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <li>No categories found.</li>
                        <?php endif; ?>
                    </ul>
                    <a href="<?php echo esc_url(get_post_type_archive_link('projects')); ?>" class="mt-6 inline-block p-1 rounded text-[#e4d198] hover:text-[#ffffff] font-medium transition-colors duration-150">
                        Explore our portfolio &rarr;
                    </a>
                </div>
    
                <div class="md:col-span-2">
                    <p class="font-semibold uppercase tracking-wider text-[#e4d198] mb-3">Featured Projects</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <?php if ($featured_projects->have_posts()) : ?>
                            <?php while ($featured_projects->have_posts()) : $featured_projects->the_post(); ?>
                                <a href="<?php the_permalink(); ?>" class="block group transition-all duration-200 ease-in-out hover:scale-[1.02]">
                                    <div class="bg-[#333333] rounded-lg overflow-hidden shadow-sm group-hover:shadow-md h-full">
                                        <?php if (has_post_thumbnail()) : ?>
                                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-32 object-cover">
                                        <?php else : ?>
                                            <img src="https://via.placeholder.com/400x250" alt="Placeholder" class="w-full h-32 object-cover">
                                        <?php endif; ?>
                                        <div class="p-3">
                                            <p class="font-semibold text-sm text-white group-hover:text-[#e4d198]">
                                                <?php the_title(); ?>
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">
                                                <?php 
                                                $terms = get_the_terms( get_the_ID(), 'project_type' ); 
                                                 if($terms) {
                                                    echo $terms && !is_wp_error($terms) && isset($terms[0]) ? esc_html($terms[0]->name) : '';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </a>
                            <?php endwhile; ?>
                            <?php wp_reset_postdata(); ?>
                        <?php else : ?>
                            <p>No featured projects found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    private function get_services_mega_menu($item = null) {
        ob_start();

        // Find child menu items of the current "Services" menu item
        $menu_items = wp_get_nav_menu_items('primary-menu');
        $columns = [];

        $featured_post = null;

        if ($menu_items && $item) {
            foreach ($menu_items as $nav_item) {
                
                if ((int)$nav_item->menu_item_parent === (int)$item->ID) {
                    // Each child becomes a column: title is the child label, links are its children
                    $column_links = [];
                    foreach ($menu_items as $sub_item) {
                        if ((int)$sub_item->menu_item_parent === (int)$nav_item->ID) {
                            $column_links[] = [
                                'label' => $sub_item->title,
                                'url'   => $sub_item->url,
                            ];
                        }
                    }
                    if(!$nav_item->linked_post_id){
                        $columns[] = [
                            'title' => $nav_item->title,
                            'links' => $column_links,
                        ];
                    }
                }

                if($nav_item->linked_post_id ) {
                    // If this is the "Services" item, get the linked post
                    $featured_post = get_post($nav_item->linked_post_id);
                }
            }
        }
        ?>
        <div id="services-mega-menu" class="absolute left-0 w-full z-30 border-y border-gray-700 bg-[#2a2a2a] shadow-2xl transition-transform duration-300 ease-in-out hidden" style="top:100%;padding-top:2rem;padding-bottom:2rem;box-shadow:0 12px 48px 0 rgba(0,0,0,0.25);">
            <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-x-8 gap-y-6 px-6 py-5 text-sm">
                <?php foreach ($columns as $col): ?>
                    <div>
                        <p class="font-semibold uppercase tracking-wider text-[#e4d198] mb-3">
                            <?php echo esc_html($col['title']); ?>

                            
                        </p>
                        <ul class="space-y-3">
                            <?php foreach ($col['links'] as $link): ?>
                                <li>
                                    <a href="<?php echo esc_url($link['url']); ?>" class="block p-1 rounded text-[#cccccc] hover:text-[#e4d198] hover:bg-[#444444] transition-colors duration-150">
                                        <?php echo esc_html($link['label']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>

                        
                    </div>
                <?php endforeach; ?>
                <?php if ($featured_post): ?>

                                <a href="<?php echo esc_url(get_permalink($featured_post->ID)); ?>" class="block group transition-all duration-200 ease-in-out hover:scale-[1.02]">
                                    <div class="bg-[#333333] rounded-lg overflow-hidden shadow-sm group-hover:shadow-md h-full">
                                        <?php if (has_post_thumbnail($featured_post->ID)) : ?>
                                            <img src="<?php echo get_the_post_thumbnail_url($featured_post->ID, 'medium'); ?>" alt="<?php echo esc_attr($featured_post->post_title); ?>" class="w-full h-32 object-cover">
                                        <?php else : ?>
                                            <img src="https://via.placeholder.com/400x250" alt="Placeholder" class="w-full h-32 object-cover">
                                        <?php endif; ?>
                                        <div class="p-3">
                                                <p class="font-semibold text-sm text-white group-hover:text-[#e4d198]">
                                                    <?php echo esc_html($featured_post->post_title); ?>
                                                </p>
                                                <p class="text-xs text-gray-400 mt-1">
                                                    <?php 
                                                    $terms = get_the_terms( $featured_post->ID, 'project_type' ); 
                                                    if($terms) {
                                                        echo $terms && !is_wp_error($terms) && isset($terms[0]) ? esc_html($terms[0]->name) : '';
                                                    }
                                                    ?>
                                                </p>
                                        </div>
                                    </div>
                                </a>

                        <?php endif; ?>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }
}

function suburbancm_enqueue_menu_script() {
    // Mobile menu. The hover megamenus (assets/js/menu.js) were retired for a flat nav.
    wp_enqueue_script(
        'suburbancm-site',
        get_theme_file_uri('/assets/js/site.js'),
        [],
        filemtime(get_theme_file_path('/assets/js/site.js')),
        true
    );
}
add_action('wp_enqueue_scripts', 'suburbancm_enqueue_menu_script');

// Client portal on ProjectAire, linked from the footer and mobile menu.
if ( ! defined( 'SUBURBANCM_CLIENT_LOGIN_URL' ) ) {
    define( 'SUBURBANCM_CLIENT_LOGIN_URL', 'https://projectaire.app/login' );
}

/**
 * Links used when a menu location has no menu assigned yet.
 *
 * @param string $set 'primary' or 'footer'.
 * @return array[] Each item: label, url, class.
 */
function suburbancm_default_links( $set ) {
    $primary = [
        [ 'label' => __( 'Projects', 'suburbancm' ), 'url' => home_url( '/projects/' ), 'class' => '' ],
        [ 'label' => __( 'Services', 'suburbancm' ), 'url' => home_url( '/services/' ), 'class' => '' ],
        [ 'label' => __( 'About', 'suburbancm' ), 'url' => home_url( '/about/' ), 'class' => '' ],
        [ 'label' => __( 'The Difference', 'suburbancm' ), 'url' => home_url( '/the-suburban-difference/' ), 'class' => '' ],
        [ 'label' => __( 'Bidding', 'suburbancm' ), 'url' => home_url( '/bidding/' ), 'class' => '' ],
        [ 'label' => __( 'Request a consultation', 'suburbancm' ), 'url' => home_url( '/contact/' ), 'class' => 'cta-button' ],
    ];
    if ( 'primary' === $set ) {
        return $primary;
    }
    return [
        [ 'label' => __( 'Projects', 'suburbancm' ), 'url' => home_url( '/projects/' ), 'class' => '' ],
        [ 'label' => __( 'Services', 'suburbancm' ), 'url' => home_url( '/services/' ), 'class' => '' ],
        [ 'label' => __( 'About', 'suburbancm' ), 'url' => home_url( '/about/' ), 'class' => '' ],
        [ 'label' => __( 'The Difference', 'suburbancm' ), 'url' => home_url( '/the-suburban-difference/' ), 'class' => '' ],
        [ 'label' => __( 'Bid opportunities', 'suburbancm' ), 'url' => home_url( '/bidding/' ), 'class' => '' ],
        [ 'label' => __( 'Safety report', 'suburbancm' ), 'url' => home_url( '/safety-report/' ), 'class' => '' ],
        [ 'label' => __( 'Contact', 'suburbancm' ), 'url' => home_url( '/contact/' ), 'class' => '' ],
        [ 'label' => __( 'Privacy policy', 'suburbancm' ), 'url' => home_url( '/privacy-policy/' ), 'class' => '' ],
    ];
}

/**
 * Print a flat menu for a location, falling back to the default links.
 *
 * @param string $location     Menu location slug.
 * @param string $fallback_set Set passed to suburbancm_default_links().
 * @param array  $extra        Extra items appended after the menu (label, url, class, external).
 */
function suburbancm_flat_menu( $location, $fallback_set, $extra = [] ) {
    $extra_html = '';
    foreach ( $extra as $link ) {
        $target      = ! empty( $link['external'] ) ? ' target="_blank" rel="noopener"' : '';
        $extra_html .= sprintf(
            '<li class="%s"><a href="%s"%s>%s</a></li>',
            esc_attr( $link['class'] ),
            esc_url( $link['url'] ),
            $target,
            esc_html( $link['label'] )
        );
    }

    if ( has_nav_menu( $location ) ) {
        wp_nav_menu( [
            'theme_location' => $location,
            'container'      => false,
            'depth'          => 1,
            'items_wrap'     => '<ul>%3$s' . $extra_html . '</ul>',
            'fallback_cb'    => false,
        ] );
        return;
    }

    echo '<ul>';
    foreach ( suburbancm_default_links( $fallback_set ) as $link ) {
        $current = untrailingslashit( $link['url'] ) === untrailingslashit( home_url( add_query_arg( [] ) ) ) ? ' current-menu-item' : '';
        printf(
            '<li class="%s"><a href="%s">%s</a></li>',
            esc_attr( trim( $link['class'] . $current ) ),
            esc_url( $link['url'] ),
            esc_html( $link['label'] )
        );
    }
    echo $extra_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped above.
    echo '</ul>';
}

/**
 * The site logo: the Customizer logo when set, otherwise the site name.
 */
function suburbancm_logo() {
    if ( has_custom_logo() ) {
        $logo_id = get_theme_mod( 'custom_logo' );
        echo wp_get_attachment_image( $logo_id, 'full', false, [
            'class' => 'custom-logo',
            'alt'   => get_bloginfo( 'name' ),
        ] );
        return;
    }
    bloginfo( 'name' );
}

// Custom Fields on Menu Items
// Add a post selector field to 2nd level menu items only
add_action('wp_nav_menu_item_custom_fields', function($item_id, $item, $depth, $args) {
    // Only show on 2nd level (depth === 1)
    if ($depth !== 1) {
        return;
    }

    // Get saved post ID
    $linked_post_id = get_post_meta($item_id, '_linked_post_id', true);

    // Query posts (example: show all 'projects' posts, adjust as needed)
    $posts = get_posts([
        'post_type'      => ['projects', 'post', 'page'], // Adjust post types as needed
        'posts_per_page' => 50,
        'orderby'        => 'title',
        'order'          => 'ASC',
    ]);
    ?>
    <p class="field-custom description description-wide">
        <label for="edit-menu-item-linked-post-<?php echo esc_attr($item_id); ?>">
            <?php _e('Link to Post/Page/Project', 'suburbancm'); ?><br>
            <select id="edit-menu-item-linked-post-<?php echo esc_attr($item_id); ?>" name="menu-item-linked-post[<?php echo esc_attr($item_id); ?>]">
                <option value=""><?php _e('None', 'suburbancm'); ?></option>
                <?php foreach ($posts as $post): ?>
                    <option value="<?php echo esc_attr($post->ID); ?>" <?php selected($linked_post_id, $post->ID); ?>>
                        <?php echo esc_html($post->post_title); ?> (<?php echo esc_html($post->post_type); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
        </label>
    </p>
    <?php
}, 10, 4);

// Save the post selector field value
add_action('wp_update_nav_menu_item', function($menu_id, $menu_item_db_id, $args) {
    if (isset($_POST['menu-item-linked-post'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_linked_post_id', intval($_POST['menu-item-linked-post'][$menu_item_db_id]));
    } else {
        delete_post_meta($menu_item_db_id, '_linked_post_id');
    }
}, 10, 3);

// Make the value available in the $item object for walkers
add_filter('wp_setup_nav_menu_item', function($menu_item) {
    $menu_item->linked_post_id = get_post_meta($menu_item->ID, '_linked_post_id', true);
    return $menu_item;
});