<?php
/**
 * Featured Projects — one large photo tile and two stacked beside it; any extras run in a row below.
 *
 * @package suburbancm
 */

$selected_projects = array_map( 'intval', (array) ( $attributes['selectedProjects'] ?? [] ) );
$title             = $attributes['title'] ?? '';
$description       = $attributes['description'] ?? '';
$button_text       = $attributes['buttonText'] ?? '';
$button_url        = $attributes['buttonUrl'] ?? '';

if ( '' === trim( wp_strip_all_tags( $title ) ) ) {
	$title = __( 'Featured projects', 'suburbancm' );
}

if ( empty( $selected_projects ) ) {
	return;
}

$query = new WP_Query(
	[
		'post_type'      => 'projects',
		'post__in'       => $selected_projects,
		'orderby'        => 'post__in',
		'posts_per_page' => count( $selected_projects ),
		'no_found_rows'  => true,
	]
);

if ( ! $query->have_posts() ) {
	return;
}

$tiles = [];
while ( $query->have_posts() ) {
	$query->the_post();
	$terms   = get_the_terms( get_the_ID(), 'project_type' );
	$tiles[] = [
		'title' => get_the_title(),
		'url'   => get_permalink(),
		'thumb' => get_post_thumbnail_id(),
		'type'  => ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '',
	];
}
wp_reset_postdata();

$tile = static function ( $item, $size_class ) {
	?>
	<a class="scm-tile <?php echo esc_attr( $size_class ); ?>" href="<?php echo esc_url( $item['url'] ); ?>">
		<?php
		if ( $item['thumb'] ) {
			echo wp_get_attachment_image( $item['thumb'], 'large', false, [ 'alt' => '', 'loading' => 'lazy' ] );
		}
		?>
		<span class="scm-tile__label">
			<?php if ( $item['type'] ) : ?>
				<span class="scm-eyebrow scm-gold"><?php echo esc_html( $item['type'] ); ?></span>
			<?php endif; ?>
			<span class="scm-d scm-tile__title"><?php echo esc_html( $item['title'] ); ?></span>
			<?php if ( 'scm-tile--feature' === $size_class ) : ?>
				<span class="scm-tile__more"><?php esc_html_e( 'View project →', 'suburbancm' ); ?></span>
			<?php endif; ?>
		</span>
	</a>
	<?php
};

$wrapper_attributes = get_block_wrapper_attributes( [ 'id' => 'projects', 'class' => 'scm-projects scm-bg-ink' ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section">
		<header class="scm-projects__head">
			<div>
				<h2 class="scm-d scm-h-l"><?php echo wp_kses_post( $title ); ?></h2>
				<?php if ( $description ) : ?>
					<p class="scm-lede"><?php echo wp_kses_post( $description ); ?></p>
				<?php endif; ?>
			</div>
			<?php if ( $button_text && $button_url ) : ?>
				<a class="scm-link" href="<?php echo esc_url( $button_url ); ?>"><?php echo wp_kses_post( $button_text ); ?></a>
			<?php endif; ?>
		</header>

		<div class="scm-projects__grid">
			<?php $tile( $tiles[0], 'scm-tile--feature' ); ?>
			<?php if ( count( $tiles ) > 1 ) : ?>
				<div class="scm-projects__side">
					<?php foreach ( array_slice( $tiles, 1, 2 ) as $item ) : ?>
						<?php $tile( $item, 'scm-tile--side' ); ?>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if ( count( $tiles ) > 3 ) : ?>
			<div class="scm-projects__more">
				<?php foreach ( array_slice( $tiles, 3 ) as $item ) : ?>
					<?php $tile( $item, 'scm-tile--side' ); ?>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
</section>
