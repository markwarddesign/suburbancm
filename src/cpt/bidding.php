<?php
// Register Custom Post Type for Bidding
function create_bidding_cpt() {
    $labels = array(
        'name'                  => _x('Bidding', 'Post Type General Name', 'suburbancm'),
        'singular_name'         => _x('Bidding', 'Post Type Singular Name', 'suburbancm'),
        'menu_name'             => __('Bidding', 'suburbancm'),
        'name_admin_bar'        => __('Bidding', 'suburbancm'),
        'add_new'               => __('Add New', 'suburbancm'),
        'add_new_item'          => __('Add New Bidding', 'suburbancm'),
        'new_item'              => __('New Bidding', 'suburbancm'),
        'edit_item'             => __('Edit Bidding', 'suburbancm'),
        'view_item'             => __('View Bidding', 'suburbancm'),
        'all_items'             => __('All Bidding', 'suburbancm'),
        'search_items'          => __('Search Bidding', 'suburbancm'),
        'not_found'             => __('Not found', 'suburbancm'),
        'not_found_in_trash'    => __('Not found in Trash', 'suburbancm'),
    );

    $args = array(
        'label'                 => __('Bidding', 'suburbancm'),
        'description'           => __('Custom Post Type for Bidding', 'suburbancm'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor'),
        'public'                => true,
        'show_ui'               => true,
        'show_in_rest'          => true,
        'has_archive'           => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-media-document',
    );

    register_post_type('bidding', $args);
}
add_action('init', 'create_bidding_cpt');

// Register Due Date meta field for Bidding CPT
function bidding_due_date_meta() {
    register_post_meta('bidding', 'due_date', array(
        'type' => 'string',
        'description' => 'Due date for bidding',
        'single' => true,
        'show_in_rest' => true,
        'auth_callback' => function() { return current_user_can('edit_posts'); }
    ));
}
add_action('init', 'bidding_due_date_meta');

// Custom query for archive-bidding.php to only show posts with future due date
add_action('pre_get_posts', function($query) {
    if (!is_admin() && $query->is_main_query() && is_post_type_archive('bidding')) {
        $meta_query = array(
            array(
                'key' => 'due_date',
                'value' => date('Y-m-d'),
                'compare' => '>=',
                'type' => 'DATE',
            )
        );
        $query->set('meta_query', $meta_query);
        $query->set('orderby', 'meta_value');
        $query->set('meta_key', 'due_date');
        $query->set('order', 'ASC');
    }
});

// Enqueue Due Date Sidebar JS for Bidding CPT in block editor
add_action('enqueue_block_editor_assets', function() {
    global $post;
    if (isset($post) && $post->post_type === 'bidding') {
        wp_enqueue_script(
            'bidding-due-date-sidebar',
            get_template_directory_uri() . '/src/blocks/bidding-due-date-sidebar.js',
            array('wp-plugins', 'wp-edit-post', 'wp-element', 'wp-components', 'wp-data', 'wp-i18n'),
            filemtime(get_template_directory() . '/src/blocks/bidding-due-date-sidebar.js'),
            true
        );
    }
});

require_once get_template_directory() . '/src/cpt/bidding-fields.php';