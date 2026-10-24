<?php
/**
 * Bid Header.
 *
 * Inside a bid the page template already shows the title, due date and submit button,
 * so this only adds its extra button. On any other page it is the page heading.
 *
 * @package suburbancm
 */

$title           = $attributes['title'] ?? '';
$button_text     = $attributes['buttonText'] ?? '';
$button_url      = $attributes['buttonUrl'] ?? '';
$hide_breadcrumb = ! empty( $attributes['hideBreadcrumb'] );

if ( is_singular( 'bidding' ) ) {
	if ( $button_text && $button_url ) {
		printf(
			'<div %s><a class="scm-btn scm-btn--ink" href="%s" target="_blank" rel="noopener">%s</a></div>',
			get_block_wrapper_attributes( [ 'class' => 'scm-bid-header scm-bid-header--inline' ] ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			esc_url( $button_url ),
			wp_kses_post( $button_text )
		);
	}
	return;
}

$parent = ( ! $hide_breadcrumb && get_post() && get_post()->post_parent ) ? get_post( get_post()->post_parent ) : null;
?>
<section <?php echo get_block_wrapper_attributes( [ 'class' => 'scm-bid-header scm-bg-ink' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-project-head">
		<?php if ( $parent ) : ?>
			<a class="scm-back" href="<?php echo esc_url( get_permalink( $parent ) ); ?>">← <?php echo esc_html( get_the_title( $parent ) ); ?></a>
		<?php endif; ?>
		<?php if ( $title ) : ?>
			<h1 class="scm-d scm-h-xl"><?php echo wp_kses_post( $title ); ?></h1>
		<?php endif; ?>
		<?php if ( $button_text && $button_url ) : ?>
			<a class="scm-btn" href="<?php echo esc_url( $button_url ); ?>" target="_blank" rel="noopener"><?php echo wp_kses_post( $button_text ); ?></a>
		<?php endif; ?>
	</div>
</section>
