<?php
/**
 * Server-side rendering for suburbancm/project-page block.
 *
 * @param array $attributes Block attributes.
 * @param string $content Inner blocks content.
 * @return string
 */

global $post;
$post_id = isset( $post ) ? $post->ID : 0;
$featured_image_url = get_the_post_thumbnail_url($post_id, 'full');

?>

<?php if ($featured_image_url): ?>
    <div class="w-full mb-16">
        <img src="<?php echo esc_url($featured_image_url); ?>" alt="" class="w-full object-cover rounded-lg" style="object-fit:cover;width:100%;" />
    </div>
<?php endif; ?>

<div class="wp-block-suburbancm-project-page flex gap-x-8">
    <div class="w-1/3">
        <h2 class="text-lg font-bold mb-4">Project Details</h2>
        <?php if (!empty($attributes['client'])): ?>
            <div class="project-detail-item mb-4">
                <h3 class="project-detail-label text-sm font-bold mb-1"><?php esc_html_e('Client', 'suburbancm'); ?></h3>
                <div class="project-detail-value"><?php echo wp_kses_post($attributes['client']); ?></div>
            </div>
        <?php endif; ?>
        <?php if (!empty($attributes['location'])): ?>
            <div class="project-detail-item mb-4">
                <h3 class="project-detail-label text-sm font-bold mb-1"><?php esc_html_e('Location', 'suburbancm'); ?></h3>
                <div class="project-detail-value"><?php echo wp_kses_post($attributes['location']); ?></div>
            </div>
        <?php endif; ?>
        <?php if (!empty($attributes['size'])): ?>
            <div class="project-detail-item mb-4">
                <h3 class="project-detail-label text-sm font-bold mb-1"><?php esc_html_e('Size', 'suburbancm'); ?></h3>
                <div class="project-detail-value"><?php echo wp_kses_post($attributes['size']); ?></div>
            </div>
        <?php endif; ?>
        <?php if (!empty($attributes['startDate'])): ?>
            <div class="project-detail-item mb-4">
                <h3 class="project-detail-label text-sm font-bold mb-1"><?php esc_html_e('Start Date', 'suburbancm'); ?></h3>
                <div class="project-detail-value">
                    <?php
                    $start_date = $attributes['startDate'];
                    if ($start_date) {
                        // Format as Month Day, Year (e.g., January 1, 2024)
                        $timestamp = strtotime($start_date);
                        echo wp_kses_post( date_i18n( 'F j, Y', $timestamp ) );
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
        <?php
        $completion_date = !empty($attributes['completionDate']) ? $attributes['completionDate'] : '';
        ?>
        <?php if (!empty($attributes['startDate'])): ?>
        <div class="project-detail-item mb-4">
            <h3 class="project-detail-label text-sm font-bold mb-1"><?php esc_html_e('Completion Date', 'suburbancm'); ?></h3>
            <div class="project-detail-value">
                <?php
                if ($completion_date) {
                    $timestamp = strtotime($completion_date);
                    echo wp_kses_post( date_i18n( 'F j, Y', $timestamp ) );
                } else {
                    if (!empty($attributes['startDate'])) {
                        // If start date is available, show TBD
                        esc_html_e('TBD', 'suburbancm');
                    } 
                }
                ?>
            </div>
        </div>
        <?php endif; ?>

    </div>
    <div class="w-2/3">
        <h2>Project Overview</h2>
        <?php echo $content; ?>
    </div>
</div>