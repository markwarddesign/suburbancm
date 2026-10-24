<?php
/**
 * Project Page — the body of a project: featured photo, facts bar, and the overview
 * (the block's inner content) on a light band.
 *
 * @package suburbancm
 */

$post_id = get_the_ID();
$info    = [
	'client'     => $attributes['client'] ?? '',
	'location'   => $attributes['location'] ?? '',
	'size'       => $attributes['size'] ?? '',
	'start'      => $attributes['startDate'] ?? '',
	'completion' => $attributes['completionDate'] ?? '',
];
$has_overview = '' !== trim( wp_strip_all_tags( (string) $content ) );
?>
<div <?php echo get_block_wrapper_attributes( [ 'class' => 'scm-project-body' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( has_post_thumbnail( $post_id ) ) : ?>
		<figure class="scm-photo-band scm-photo-band--tall">
			<?php echo get_the_post_thumbnail( $post_id, 'full', [ 'alt' => '', 'sizes' => '100vw' ] ); ?>
		</figure>
	<?php endif; ?>

	<?php suburbancm_project_spec( $info ); ?>

	<?php if ( $has_overview ) : ?>
		<section class="scm-project-overview scm-bg-bone">
			<div class="scm-wrap scm-section scm-project-overview__inner">
				<h2 class="scm-d scm-h-l"><?php esc_html_e( 'Project overview.', 'suburbancm' ); ?></h2>
				<div class="scm-project-overview__body"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- inner blocks. ?></div>
			</div>
		</section>
	<?php endif; ?>
</div>
