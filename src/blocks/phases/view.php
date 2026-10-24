<?php
/**
 * Process Phases — heading, then each phase: huge gold label + title + summary beside a grid of steps.
 *
 * @package suburbancm
 */

$title       = $attributes['title'] ?? '';
$description = $attributes['description'] ?? '';
$phases      = (array) ( $attributes['phases'] ?? [] );

$wrapper_attributes = get_block_wrapper_attributes( [ 'id' => 'phases', 'class' => 'scm-phases scm-bg-ink' ] );
?>
<section <?php echo $wrapper_attributes; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-wrap scm-section">
		<?php if ( $title ) : ?>
			<h2 class="scm-d scm-h-l"><?php echo wp_kses_post( $title ); ?></h2>
		<?php endif; ?>
		<?php if ( $description ) : ?>
			<p class="scm-lede scm-phases__intro"><?php echo wp_kses_post( $description ); ?></p>
		<?php endif; ?>

		<?php foreach ( $phases as $phase ) : ?>
			<article class="scm-phase">
				<div class="scm-phase__lead">
					<?php if ( ! empty( $phase['title'] ) ) : ?>
						<p class="scm-d scm-phase__label"><?php echo wp_kses_post( $phase['title'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $phase['subtitle'] ) ) : ?>
						<h3 class="scm-d scm-h-s"><?php echo wp_kses_post( $phase['subtitle'] ); ?></h3>
					<?php endif; ?>
					<?php if ( ! empty( $phase['description'] ) ) : ?>
						<p class="scm-phase__summary"><?php echo wp_kses_post( $phase['description'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $phase['image'] ) ) : ?>
						<img class="scm-phase__image" src="<?php echo esc_url( $phase['image'] ); ?>" alt="<?php echo esc_attr( $phase['imageAlt'] ?? '' ); ?>" loading="lazy">
					<?php endif; ?>
				</div>
				<?php if ( ! empty( $phase['steps'] ) ) : ?>
					<div class="scm-phase__steps">
						<?php foreach ( (array) $phase['steps'] as $step ) : ?>
							<div class="scm-step scm-reveal">
								<?php if ( ! empty( $step['heading'] ) ) : ?>
									<h4><?php echo wp_kses_post( $step['heading'] ); ?></h4>
								<?php endif; ?>
								<?php if ( ! empty( $step['text'] ) && is_array( $step['text'] ) ) : ?>
									<ul>
										<?php foreach ( $step['text'] as $item ) : ?>
											<?php if ( '' !== trim( (string) $item ) ) : ?>
												<li><?php echo wp_kses_post( $item ); ?></li>
											<?php endif; ?>
										<?php endforeach; ?>
									</ul>
								<?php elseif ( ! empty( $step['text'] ) ) : ?>
									<p><?php echo wp_kses_post( $step['text'] ); ?></p>
								<?php endif; ?>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</article>
		<?php endforeach; ?>
	</div>
</section>
