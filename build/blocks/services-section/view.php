<?php
/**
 * Services — numbered, heavily ruled rows on bone.
 *
 * Layout "rows" (Home): number · title + description · feature list.
 * Layout "groups" (Services page): number + title + photo · sub-items, where a
 * feature written "Title: description" shows as a bold title over its text.
 *
 * @package suburbancm
 */

$title       = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$services    = $attributes['services'] ?? [];
$layout      = ( $attributes['layout'] ?? 'rows' ) === 'groups' ? 'groups' : 'rows';

$wrapper_attributes = get_block_wrapper_attributes( [ 'class' => 'scm-services scm-bg-bone scm-services--' . $layout ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section">
		<?php if ( $title || $description ) : ?>
			<header class="scm-services__head">
				<?php if ( $title ) : ?>
					<h2 class="scm-d scm-h-l"><?php echo wp_kses_post( $title ); ?></h2>
				<?php endif; ?>
				<?php if ( $description ) : ?>
					<p class="scm-lede"><?php echo wp_kses_post( $description ); ?></p>
				<?php endif; ?>
			</header>
		<?php endif; ?>

		<?php foreach ( $services as $i => $service ) : ?>
			<?php
			$number   = str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT );
			$features = array_filter( (array) ( $service['features'] ?? [] ), static fn( $f ) => '' !== trim( wp_strip_all_tags( (string) $f ) ) );
			?>
			<article class="scm-services__row">
				<?php if ( 'groups' === $layout ) : ?>
					<div class="scm-services__lead">
						<div class="scm-services__title">
							<span class="scm-d scm-services__num" aria-hidden="true"><?php echo esc_html( $number ); ?></span>
							<?php if ( ! empty( $service['title'] ) ) : ?>
								<h3 class="scm-d scm-h-s"><?php echo wp_kses_post( $service['title'] ); ?></h3>
							<?php endif; ?>
						</div>
						<?php if ( ! empty( $service['description'] ) ) : ?>
							<p class="scm-services__desc"><?php echo wp_kses_post( $service['description'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $service['image'] ) ) : ?>
							<div class="scm-services__img">
								<img src="<?php echo esc_url( $service['image'] ); ?>" alt="<?php echo esc_attr( $service['alt'] ?? '' ); ?>" loading="lazy">
							</div>
						<?php endif; ?>
					</div>
					<div class="scm-services__items">
						<?php foreach ( $features as $feature ) : ?>
							<?php
							$parts = explode( ':', wp_strip_all_tags( (string) $feature ), 2 );
							?>
							<div class="scm-services__item">
								<?php if ( 2 === count( $parts ) ) : ?>
									<h4><?php echo esc_html( trim( $parts[0] ) ); ?></h4>
									<p><?php echo esc_html( trim( $parts[1] ) ); ?></p>
								<?php else : ?>
									<h4><?php echo esc_html( trim( $parts[0] ) ); ?></h4>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php else : ?>
					<span class="scm-d scm-services__num" aria-hidden="true"><?php echo esc_html( $number ); ?></span>
					<div class="scm-services__body">
						<?php if ( ! empty( $service['title'] ) ) : ?>
							<h3 class="scm-d scm-h-s"><?php echo wp_kses_post( $service['title'] ); ?></h3>
						<?php endif; ?>
						<?php if ( ! empty( $service['description'] ) ) : ?>
							<p class="scm-services__desc"><?php echo wp_kses_post( $service['description'] ); ?></p>
						<?php endif; ?>
					</div>
					<?php if ( $features ) : ?>
						<ul class="scm-services__features">
							<?php foreach ( $features as $feature ) : ?>
								<li><?php echo wp_kses_post( $feature ); ?></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				<?php endif; ?>
			</article>
		<?php endforeach; ?>
	</div>
</section>
