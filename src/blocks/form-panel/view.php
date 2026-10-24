<?php
/**
 * Form Panel — the form (inner blocks, e.g. WPForms) beside supporting info.
 *
 * The side column shows whatever is filled in: an office box, a heading with text,
 * a ruled list and a photo, and link cards.
 *
 * @package suburbancm
 */

$form_title  = $attributes['formTitle'] ?? '';
$form_note   = $attributes['formNote'] ?? '';
$boxed       = ! empty( $attributes['boxed'] );
$aside_left  = ( $attributes['asidePosition'] ?? 'right' ) === 'left';
$aside_title = $attributes['asideTitle'] ?? '';
$aside_text  = $attributes['asideText'] ?? '';
$aside_list  = array_filter( (array) ( $attributes['asideList'] ?? [] ), static fn( $i ) => '' !== trim( (string) $i ) );
$aside_image = $attributes['asideImage'] ?? '';
$aside_alt   = $attributes['asideImageAlt'] ?? '';
$office      = [
	'label' => $attributes['officeLabel'] ?? '',
	'title' => $attributes['officeTitle'] ?? '',
	'text'  => $attributes['officeText'] ?? '',
];
$links = array_filter( (array) ( $attributes['links'] ?? [] ), static fn( $l ) => ! empty( $l['title'] ) && ! empty( $l['url'] ) );

$wrapper_attributes = get_block_wrapper_attributes(
	[ 'class' => 'scm-form-panel scm-bg-bone' . ( $aside_left ? ' is-aside-left' : '' ) ]
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section scm-form-panel__inner">
		<div class="scm-form-panel__form<?php echo $boxed ? ' is-boxed' : ''; ?>">
			<?php if ( $form_title ) : ?>
				<h2 class="scm-d scm-h-m"><?php echo wp_kses_post( $form_title ); ?></h2>
			<?php endif; ?>
			<div class="scm-form"><?php echo $content; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- rendered inner blocks. ?></div>
			<?php if ( $form_note ) : ?>
				<p class="scm-form-panel__note"><?php echo wp_kses_post( $form_note ); ?></p>
			<?php endif; ?>
		</div>

		<aside class="scm-form-panel__aside">
			<?php if ( $office['title'] ) : ?>
				<div class="scm-office">
					<?php if ( $office['label'] ) : ?>
						<p class="scm-eyebrow scm-gold"><?php echo esc_html( $office['label'] ); ?></p>
					<?php endif; ?>
					<p class="scm-d scm-office__title"><?php echo esc_html( $office['title'] ); ?></p>
					<?php if ( $office['text'] ) : ?>
						<p class="scm-office__text"><?php echo wp_kses_post( $office['text'] ); ?></p>
					<?php endif; ?>
				</div>
			<?php endif; ?>

			<?php if ( $aside_title ) : ?>
				<h2 class="scm-d scm-h-m"><?php echo wp_kses_post( $aside_title ); ?></h2>
			<?php endif; ?>
			<?php if ( $aside_text ) : ?>
				<p class="scm-form-panel__text"><?php echo wp_kses_post( $aside_text ); ?></p>
			<?php endif; ?>
			<?php if ( $aside_list ) : ?>
				<ul class="scm-heavy-list">
					<?php foreach ( $aside_list as $item ) : ?>
						<li><?php echo wp_kses_post( $item ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
			<?php if ( $aside_image ) : ?>
				<div class="scm-form-panel__image">
					<img src="<?php echo esc_url( $aside_image ); ?>" alt="<?php echo esc_attr( $aside_alt ); ?>" loading="lazy">
				</div>
			<?php endif; ?>

			<?php foreach ( $links as $link ) : ?>
				<a class="scm-link-card" href="<?php echo esc_url( $link['url'] ); ?>">
					<span class="scm-d scm-link-card__title"><?php echo esc_html( $link['title'] ); ?></span>
					<?php if ( ! empty( $link['text'] ) ) : ?>
						<span class="scm-link-card__text"><?php echo esc_html( $link['text'] ); ?> →</span>
					<?php endif; ?>
				</a>
			<?php endforeach; ?>
		</aside>
	</div>
</section>
