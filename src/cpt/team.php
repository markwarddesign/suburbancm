<?php
// Register "Team" Custom Post Type
add_action('init', function() {
    $labels = [
        'name'               => __('Team Members', 'suburbancm'),
        'singular_name'      => __('Team Member', 'suburbancm'),
        'add_new'            => __('Add New', 'suburbancm'),
        'add_new_item'       => __('Add New Team Member', 'suburbancm'),
        'edit_item'          => __('Edit Team Member', 'suburbancm'),
        'new_item'           => __('New Team Member', 'suburbancm'),
        'view_item'          => __('View Team Member', 'suburbancm'),
        'search_items'       => __('Search Team Members', 'suburbancm'),
        'not_found'          => __('No team members found', 'suburbancm'),
        'not_found_in_trash' => __('No team members found in Trash', 'suburbancm'),
        'menu_name'          => __('Team', 'suburbancm'),
    ];

    $args = [
        'labels'             => $labels,
        'public'             => true,
        'has_archive'        => true,
        'rewrite'            => ['slug' => 'team'],
        'supports'           => ['title', 'editor', 'thumbnail', 'excerpt'],
        'menu_icon'          => 'dashicons-groups',
        'show_in_rest'       => true,
    ];

    register_post_type('team', $args);
});

// Optionally, add custom fields using ACF or similar plugin for role, social, etc.
if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group([
    'key' => 'group_team_member',
    'title' => 'Team Member Details',
    'fields' => [
        [
            'key' => 'field_role',
            'label' => 'Role/Position',
            'name' => 'role',
            'type' => 'text',
        ],
        [
            'key' => 'field_linkedin',
            'label' => 'LinkedIn URL',
            'name' => 'linkedin',
            'type' => 'url',
        ],
        [
            'key' => 'field_twitter',
            'label' => 'Twitter URL',
            'name' => 'twitter',
            'type' => 'url',
        ],
        [
            'key' => 'field_email',
            'label' => 'Email',
            'name' => 'email',
            'type' => 'email',
        ],
        [
            'key' => 'field_skills',
            'label' => 'Key Skills & Expertise',
            'name' => 'skills',
            'type' => 'repeater',
            'sub_fields' => [
                [
                    'key' => 'field_skill',
                    'label' => 'Skill',
                    'name' => 'skill',
                    'type' => 'text',
                ],
            ],
        ],
        [
            'key' => 'field_personal_note',
            'label' => 'Personal Note',
            'name' => 'personal_note',
            'type' => 'textarea',
        ],
    ],
    'location' => [
        [
            [
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'team',
            ],
        ],
    ],
]);

endif;