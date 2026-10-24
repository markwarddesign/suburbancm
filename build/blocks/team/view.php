<?php
/**
 * Team — each member as a large photo beside role, name, short bio, profile link and a consultation button.
 *
 * @package suburbancm
 */

$title      = $attributes['title'] ?? '';
$hide_title = ! empty( $attributes['hideTitle'] );
$show_all   = $attributes['showAll'] ?? true;
$selected   = array_map( 'intval', (array) ( $attributes['selectedTeamMembers'] ?? [] ) );
$cta_text   = $attributes['ctaText'] ?? '';
$cta_url    = $attributes['ctaUrl'] ?? '';

$args = [
	'post_type'      => 'team',
	'posts_per_page' => 100,
	'orderby'        => 'menu_order',
	'order'          => 'ASC',
	'no_found_rows'  => true,
];
if ( ! $show_all && $selected ) {
	$args['post__in'] = $selected;
	$args['orderby']  = 'post__in';
}
$query = new WP_Query( $args );

if ( ! $query->have_posts() ) {
	return;
}

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'scm-team scm-bg-ink' ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section">
		<?php if ( $title && ! $hide_title ) : ?>
			<h2 class="scm-eyebrow scm-gold scm-team__title"><?php echo wp_kses_post( $title ); ?></h2>
		<?php endif; ?>
		<?php
		while ( $query->have_posts() ) :
			$query->the_post();
			$role       = function_exists( 'get_field' ) ? get_field( 'role' ) : get_post_meta( get_the_ID(), 'role', true );
			$first_name = strtok( get_the_title(), ' ' );
			?>
			<article class="scm-member">
				<div class="scm-member__photo">
					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail( 'large', [ 'alt' => get_the_title() ] );
					}
					?>
				</div>
				<div class="scm-member__text">
					<?php if ( $role ) : ?>
						<p class="scm-eyebrow scm-gold"><?php echo esc_html( $role ); ?></p>
					<?php endif; ?>
					<h3 class="scm-d scm-h-l"><?php the_title(); ?>.</h3>
					<p class="scm-lede"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 55 ) ); ?></p>
					<div class="scm-btns">
						<a class="scm-btn" href="<?php the_permalink(); ?>">
							<?php
							/* translators: %s: team member's first name */
							printf( esc_html__( "View %s's profile", 'suburbancm' ), esc_html( $first_name ) );
							?>
						</a>
						<?php if ( $cta_text && $cta_url ) : ?>
							<a class="scm-btn scm-btn--line" href="<?php echo esc_url( $cta_url ); ?>"><?php echo esc_html( $cta_text ); ?></a>
						<?php endif; ?>
					</div>
				</div>
			</article>
		<?php endwhile; ?>
		<?php wp_reset_postdata(); ?>
	</div>
</section>
