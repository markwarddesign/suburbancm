<?php
/**
 * ProjectAire — what clients get on the platform.
 *
 * "band" (Home): logo, headline, owner benefits, buttons, desktop + phone screenshots.
 * "detailed" (The Difference): heading and intro, then During construction and At handoff,
 * each beside its own screenshot.
 *
 * @package suburbancm
 */

$asset = static fn( $file ) => get_theme_file_uri( 'assets/images/projectaire/' . $file );
$clean = static fn( $list ) => array_filter( (array) $list, static fn( $f ) => '' !== trim( wp_strip_all_tags( (string) $f ) ) );
$is_external = static function ( $url ) {
	$host = wp_parse_url( $url, PHP_URL_HOST );
	return $host && wp_parse_url( home_url(), PHP_URL_HOST ) !== $host;
};
$link = static function ( $class, $url, $text ) use ( $is_external ) {
	if ( ! $text || ! $url ) {
		return;
	}
	printf(
		'<a class="%s" href="%s"%s>%s</a>',
		esc_attr( $class ),
		esc_url( $url ),
		$is_external( $url ) ? ' target="_blank" rel="noopener"' : '',
		wp_kses_post( $text )
	);
};

$layout          = ( $attributes['layout'] ?? 'band' ) === 'detailed' ? 'detailed' : 'band';
$title           = $attributes['title'] ?? '';
$title_highlight = $attributes['titleHighlight'] ?? '';
$text            = $attributes['text'] ?? '';
$image           = ( $attributes['image'] ?? '' ) ?: $asset( 'overview.jpg' );
$image_alt       = $attributes['imageAlt'] ?? '';
$secondary_text  = $attributes['secondaryText'] ?? '';
$secondary_url   = $attributes['secondaryUrl'] ?? '';

$wrapper_attributes = get_block_wrapper_attributes(
	[
		'id'    => 'projectaire',
		'class' => 'scm-pa scm-pa--' . $layout . ( 'detailed' === $layout ? ' scm-bg-bone' : ' scm-bg-ink-2' ),
	]
);
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<?php if ( 'band' === $layout ) : ?>
		<?php
		$features    = $clean( $attributes['features'] ?? [] );
		$phone_image = ( $attributes['phoneImage'] ?? '' ) ?: $asset( 'overview-phone.jpg' );
		$caption     = $attributes['caption'] ?? '';
		?>
		<div class="scm-wrap scm-section scm-pa__inner">
			<div class="scm-pa__text">
				<img class="scm-pa__logo" src="<?php echo esc_url( $asset( 'projectaire-logo.png' ) ); ?>" alt="ProjectAire" width="220" height="28">
				<h2 class="scm-d scm-h-l">
					<?php echo wp_kses_post( $title ); ?>
					<?php if ( $title_highlight ) : ?>
						<span class="scm-gold"><?php echo wp_kses_post( $title_highlight ); ?></span>
					<?php endif; ?>
				</h2>
				<?php if ( $text ) : ?>
					<p class="scm-lede"><?php echo wp_kses_post( $text ); ?></p>
				<?php endif; ?>
				<?php if ( $features ) : ?>
					<ul class="scm-rules">
						<?php foreach ( $features as $feature ) : ?>
							<li><?php echo wp_kses_post( $feature ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<div class="scm-btns">
					<?php $link( 'scm-btn', $attributes['buttonUrl'] ?? '', $attributes['buttonText'] ?? '' ); ?>
					<?php $link( 'scm-btn scm-btn--line', $secondary_url, $secondary_text ); ?>
				</div>
			</div>
			<figure class="scm-pa__shots">
				<img class="scm-pa__desktop" src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy">
				<img class="scm-pa__phone" src="<?php echo esc_url( $phone_image ); ?>" alt="" loading="lazy">
				<?php if ( $caption ) : ?>
					<figcaption><?php echo esc_html( $caption ); ?></figcaption>
				<?php endif; ?>
			</figure>
		</div>
	<?php else : ?>
		<?php
		$during_features = $clean( $attributes['duringFeatures'] ?? [] );
		$handoff_image   = ( $attributes['handoffImage'] ?? '' ) ?: $asset( 'owners-manual.jpg' );
		?>
		<div class="scm-wrap scm-section">
			<header class="scm-pa__head">
				<div class="scm-pa__head-title">
					<?php if ( ! empty( $attributes['eyebrow'] ) ) : ?>
						<p class="scm-eyebrow"><?php echo wp_kses_post( $attributes['eyebrow'] ); ?></p>
					<?php endif; ?>
					<h2 class="scm-d scm-h-l"><?php echo wp_kses_post( $title ); ?></h2>
				</div>
				<?php if ( $text ) : ?>
					<p class="scm-lede"><?php echo wp_kses_post( $text ); ?></p>
				<?php endif; ?>
			</header>

			<div class="scm-pa__part">
				<div class="scm-pa__part-text">
					<h3 class="scm-d scm-h-s"><?php echo wp_kses_post( $attributes['duringTitle'] ?? '' ); ?></h3>
					<?php if ( ! empty( $attributes['duringText'] ) ) : ?>
						<p><?php echo wp_kses_post( $attributes['duringText'] ); ?></p>
					<?php endif; ?>
					<?php if ( $during_features ) : ?>
						<ul class="scm-rules">
							<?php foreach ( $during_features as $feature ) : ?>
								<li><?php echo wp_kses_post( $feature ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>
				<figure class="scm-pa__shot">
					<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" loading="lazy">
					<?php if ( ! empty( $attributes['duringCaption'] ) ) : ?>
						<figcaption><?php echo esc_html( $attributes['duringCaption'] ); ?></figcaption>
					<?php endif; ?>
				</figure>
			</div>

			<div class="scm-pa__part scm-pa__part--reverse">
				<figure class="scm-pa__shot scm-pa__shot--gold">
					<img src="<?php echo esc_url( $handoff_image ); ?>" alt="<?php echo esc_attr( $attributes['handoffImageAlt'] ?? '' ); ?>" loading="lazy">
					<?php if ( ! empty( $attributes['handoffCaption'] ) ) : ?>
						<figcaption><?php echo esc_html( $attributes['handoffCaption'] ); ?></figcaption>
					<?php endif; ?>
				</figure>
				<div class="scm-pa__part-text">
					<h3 class="scm-d scm-h-s"><?php echo wp_kses_post( $attributes['handoffTitle'] ?? '' ); ?></h3>
					<?php if ( ! empty( $attributes['handoffLead'] ) ) : ?>
						<p class="scm-pa__lead"><?php echo wp_kses_post( $attributes['handoffLead'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $attributes['handoffText'] ) ) : ?>
						<p><?php echo wp_kses_post( $attributes['handoffText'] ); ?></p>
					<?php endif; ?>
					<div class="scm-btns">
						<?php $link( 'scm-btn scm-btn--ink', $secondary_url, $secondary_text ); ?>
						<?php $link( 'scm-btn scm-btn--line', $attributes['aboutUrl'] ?? '', $attributes['aboutText'] ?? '' ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>
