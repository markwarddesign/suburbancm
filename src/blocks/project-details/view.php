<?php
// Only render if in the loop and post type is 'projects'
global $post;
if ( ! isset( $post ) || get_post_type( $post ) !== 'projects' ) {
    return;
}

$client = $meta['_wp_projects_client'] ?? '';
$location = $meta['_wp_projects_location'] ?? '';
$size = $meta['_wp_projects_size'] ?? '';
$start_date = $meta['_wp_projects_start_date'] ?? '';
$completion_date = $meta['_wp_projects_completion_date'] ?? '';
$subtitle = get_post_meta( $post->ID, '_wp_projects_subtitle', true );
$description = get_post_meta( $post->ID, '_wp_projects_short_description', true );
?>
<div class="project-details-block">
    <h2 class="project-details-title">Project Details</h2>
    <ul class="project-details-list">
        <?php if ( $client ) : ?>
            <li><strong>Client:</strong> <?php echo wp_kses_post( $client ); ?></li>
        <?php endif; ?>
        <?php if ( $location ) : ?>
            <li><strong>Location:</strong> <?php echo wp_kses_post( $location ); ?></li>
        <?php endif; ?>
        <?php if ( $size ) : ?>
            <li><strong>Size:</strong> <?php echo wp_kses_post( $size ); ?></li>
        <?php endif; ?>
        <?php if ( $start_date ) : ?>
            <li><strong>Start Date:</strong> <?php echo wp_kses_post( $start_date ); ?></li>
        <?php endif; ?>
        <?php if ( $completion_date ) : ?>
            <li><strong>Completion Date:</strong> <?php echo wp_kses_post( $completion_date ); ?></li>
        <?php endif; ?>
    </ul>
    <?php if ( $subtitle ) : ?>
        <div class="project-details-subtitle"><strong>Subtitle:</strong> <?php echo wp_kses_post( $subtitle ); ?></div>
    <?php endif; ?>
    <?php if ( $description ) : ?>
        <div class="project-details-description"><?php echo wp_kses_post( wpautop( $description ) ); ?></div>
    <?php endif; ?>
</div>
