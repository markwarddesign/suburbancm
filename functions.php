<?php

// Theme support
function suburbancm_theme_support() {
    // add_theme_support('editor-color-palette'); // Enable custom color palette
    add_theme_support('wp-block-styles'); // Enable block styles
    add_theme_support('editor-styles'); // Enable editor styles
    add_theme_support('align-wide'); // Enable wide alignment
    add_theme_support('post-thumbnails');
    add_theme_support( 'title-tag' );
}
add_action('after_setup_theme', 'suburbancm_theme_support');

function suburban_theme_setup() {
    // Add support for custom logo
    add_theme_support( 'custom-logo', array(
        'height'      => 53, // Set the height of the logo
        'width'       => 300, // Set the width of the logo
        'flex-height' => true, // Allow flexible height
        'flex-width'  => true, // Allow flexible width
        'header-text' => array( 'site-title', 'site-description' ), // Optionally hide header text
    ) );
}
add_action( 'after_setup_theme', 'suburban_theme_setup' );


// Register custom block category
function suburbancm_add_block_category( $categories ) {
    $suburban_category = [
        [
            'slug'  => 'suburban',
            'title' => __( 'Suburban Blocks', 'suburbancm' ),
            'icon'  => 'building', // Relevant Dashicon for construction-related blocks
        ],
    ];

    // Ensure the custom category appears first
    return array_merge( $suburban_category, $categories );
}
add_filter( 'block_categories_all', 'suburbancm_add_block_category' );


function suburbancm_register_blocks() {
    $blocks_dir = get_theme_file_path( '/build/blocks/' );

    if ( ! is_dir( $blocks_dir ) ) {
        return;
    }

    $block_folders = glob( $blocks_dir . '*', GLOB_ONLYDIR );

    foreach ( $block_folders as $block_folder ) {
        if ( file_exists( $block_folder . '/block.json' ) ) {
            register_block_type( $block_folder );
        }
    }
}
add_action( 'init', 'suburbancm_register_blocks' );

function suburbancm_enqueue_editor_styles() {
    // Enqueue block editor styles
    wp_enqueue_style(
        'suburbancm-editor-style',
        get_theme_file_uri('/assets/css/dist/editor.css'),
        [],
        filemtime(get_theme_file_path('/assets/css/dist/editor.css'))
    );
}
add_action('enqueue_block_editor_assets', 'suburbancm_enqueue_editor_styles', 20);

function suburbancm_enqueue_styles() {
    // Enqueue frontend styles
    wp_enqueue_style(
        'suburbancm-style',
        get_theme_file_uri('/assets/css/dist/style.css'),
        [],
        filemtime(get_theme_file_path('/assets/css/dist/style.css'))
    );
}
add_action('wp_enqueue_scripts', 'suburbancm_enqueue_styles');

function suburbancm_enqueue_testimonials_slider() {
    // Check if the block is present on the page
    if (has_block('suburbancm/testimonials')) {
        wp_enqueue_script(
            'suburbancm-testimonials-slider',
            get_theme_file_uri('/src/blocks/testimonials/slider.js'),
            [],
            filemtime(get_theme_file_path('/src/blocks/testimonials/slider.js')),
            true // Load in the footer
        );
    }
}
add_action('wp_enqueue_scripts', 'suburbancm_enqueue_testimonials_slider');

function suburban_enqueue_glightbox() {
    if (is_singular('projects')) {
        wp_enqueue_style('glightbox', 'https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css', [], null);
        wp_enqueue_script('glightbox', 'https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js', [], null, true);
        wp_add_inline_script('glightbox', 'document.addEventListener("DOMContentLoaded",function(){if(window.GLightbox){GLightbox({selector:\'.wp-block-gallery a[href$=\".jpg\"], .wp-block-gallery a[href$=\".jpeg\"], .wp-block-gallery a[href$=\".png\"], .wp-block-gallery a[href$=\".gif\"]\'})}});');
    }
}
add_action('wp_enqueue_scripts', 'suburban_enqueue_glightbox');

// Menu
include_once get_theme_file_path('/src/menu/menu.php');

// Custom Post Types
include_once get_theme_file_path('/src/cpt/projects.php');
include_once get_theme_file_path('/src/cpt/team.php');
include_once get_theme_file_path('/src/cpt/bidding.php');