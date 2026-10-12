<?php
// Register Custom Post Type for Projects
function create_projects_cpt() {
    $labels = array(
        'name'                  => _x('Projects', 'Post Type General Name', 'suburbancm'),
        'singular_name'         => _x('Project', 'Post Type Singular Name', 'suburbancm'),
        'menu_name'             => __('Projects', 'suburbancm'),
        'name_admin_bar'        => __('Project', 'suburbancm'),
        'archives'              => __('Project Archives', 'suburbancm'),
        'attributes'            => __('Project Attributes', 'suburbancm'),
        'parent_item_colon'     => __('Parent Project:', 'suburbancm'),
        'all_items'             => __('All Projects', 'suburbancm'),
        'add_new_item'          => __('Add New Project', 'suburbancm'),
        'add_new'               => __('Add New', 'suburbancm'),
        'new_item'              => __('New Project', 'suburbancm'),
        'edit_item'             => __('Edit Project', 'suburbancm'),
        'update_item'           => __('Update Project', 'suburbancm'),
        'view_item'             => __('View Project', 'suburbancm'),
        'view_items'            => __('View Projects', 'suburbancm'),
        'search_items'          => __('Search Project', 'suburbancm'),
        'not_found'             => __('Not found', 'suburbancm'),
        'not_found_in_trash'    => __('Not found in Trash', 'suburbancm'),
    );

    $args = array(
        'label'                 => __('Project', 'suburbancm'),
        'description'           => __('Custom Post Type for Projects', 'suburbancm'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'thumbnail', 'custom-fields'),
        'taxonomies'            => array('project_type', 'services'),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_rest'          => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'template'              => [['suburbancm/project-page', []]],
        'template_lock'         => false,
    );

    register_post_type('projects', $args);
}
add_action('init', 'create_projects_cpt', 0);

// Register meta fields for the REST API
function register_project_meta() {
    $fields = [
        '_wp_projects_subtitle',
        '_wp_projects_client',
        '_wp_projects_location',
        '_wp_projects_size',
        '_wp_projects_start_date',
        '_wp_projects_completion_date',
        '_wp_projects_short_description',
    ];
    foreach ($fields as $field) {
        register_post_meta('projects', $field, [
            'show_in_rest' => true,
            'single' => true,
            'type' => 'string',
            'auth_callback' => function($allowed, $meta_key, $post_id, $user_id, $cap, $caps) {
                error_log('Meta auth check: meta_key=' . $meta_key . ', post_id=' . $post_id . ', user_id=' . $user_id . ', allowed=' . ($allowed ? 'true' : 'false'));
                return current_user_can('edit_post', $post_id);
            },
        ]);
    }
}
add_action('init', 'register_project_meta');

// Debug REST API permission errors
add_filter('rest_pre_dispatch', function($result, $server, $request) {
    if ($request->get_method() === 'POST' && preg_match('/\/wp\/v2\/projects\/\d+/', $request->get_route())) {
        error_log('REST API request: ' . print_r($request->get_params(), true));
        if (is_wp_error($result)) {
            error_log('REST API error: ' . print_r($result, true));
        }
    }
    return $result;
}, 10, 3);

// Register Custom Taxonomy for Services Provided
function register_services_taxonomy() {
    $labels = array(
        'name'              => _x('Services Provided', 'taxonomy general name', 'wp-projects-plugin'),
        'singular_name'     => _x('Service', 'taxonomy singular name', 'wp-projects-plugin'),
        'search_items'      => __('Search Services', 'wp-projects-plugin'),
        'all_items'         => __('All Services', 'wp-projects-plugin'),
        'parent_item'       => __('Parent Service', 'wp-projects-plugin'),
        'parent_item_colon' => __('Parent Service:', 'wp-projects-plugin'),
        'edit_item'         => __('Edit Service', 'wp-projects-plugin'),
        'update_item'       => __('Update Service', 'wp-projects-plugin'),
        'add_new_item'      => __('Add New Service', 'wp-projects-plugin'),
        'new_item_name'     => __('New Service Name', 'wp-projects-plugin'),
        'menu_name'         => __('Services', 'wp-projects-plugin'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'service'),
    );

    register_taxonomy('services', array('projects'), $args);

    // Add terms to the taxonomy
    if (!term_exists('General Contracting', 'services')) {
        wp_insert_term('General Contracting', 'services');
    }
    if (!term_exists('Construction Management', 'services')) {
        wp_insert_term('Construction Management', 'services');
    }
    if (!term_exists('Pre-construction', 'services')) {
        wp_insert_term('Pre-construction', 'services');
    }
}
add_action('init', 'register_services_taxonomy');

// Register Custom Taxonomy for Project Type
function register_project_type_taxonomy() {
    $labels = array(
        'name'              => _x('Project Types', 'taxonomy general name', 'wp-projects-plugin'),
        'singular_name'     => _x('Project Type', 'taxonomy singular name', 'wp-projects-plugin'),
        'search_items'      => __('Search Project Types', 'wp-projects-plugin'),
        'all_items'         => __('All Project Types', 'wp-projects-plugin'),
        'parent_item'       => __('Parent Project Type', 'wp-projects-plugin'),
        'parent_item_colon' => __('Parent Project Type:', 'wp-projects-plugin'),
        'edit_item'         => __('Edit Project Type', 'wp-projects-plugin'),
        'update_item'       => __('Update Project Type', 'wp-projects-plugin'),
        'add_new_item'      => __('Add New Project Type', 'wp-projects-plugin'),
        'new_item_name'     => __('New Project Type Name', 'wp-projects-plugin'),
        'menu_name'         => __('Project Types', 'wp-projects-plugin'),
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_in_rest'      => true,
        'show_admin_column' => true,
        'query_var'         => true,
        'rewrite'           => array('slug' => 'project-type'),
        'has_archive'       => true,
    );

    register_taxonomy('project_type', array('projects'), $args);

    // Add default terms to the taxonomy
    if (!term_exists('Commercial', 'project_type')) {
        wp_insert_term('Commercial', 'project_type');
    }
    if (!term_exists('Industrial', 'project_type')) {
        wp_insert_term('Industrial', 'project_type');
    }
    if (!term_exists('Residential', 'project_type')) {
        wp_insert_term('Residential', 'project_type');
    }
    if (!term_exists('Institutional', 'project_type')) {
        wp_insert_term('Institutional', 'project_type');
    }
}
add_action('init', 'register_project_type_taxonomy');