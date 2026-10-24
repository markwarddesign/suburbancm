<?php
/**
 * Bid Documents — one row per file with its name, type and a download link.
 *
 * @package suburbancm
 */

$pdfs  = array_filter( (array) ( $attributes['pdfs'] ?? [] ), static fn( $p ) => ! empty( $p['url'] ) );
$title = $attributes['blockTitle'] ?? '';
$title = $title ?: __( 'Bid documents', 'suburbancm' );
?>
<section <?php echo get_block_wrapper_attributes( [ 'class' => 'scm-docs' ] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="scm-docs__inner">
		<h2 class="scm-d scm-h-s"><?php echo wp_kses_post( $title ); ?></h2>
		<?php if ( $pdfs ) : ?>
			<ul class="scm-docs__list">
				<?php foreach ( $pdfs as $pdf ) : ?>
					<?php
					$url  = $pdf['url'];
					$name = ! empty( $pdf['name'] ) ? $pdf['name'] : basename( wp_parse_url( $url, PHP_URL_PATH ) );
					$ext  = strtoupper( pathinfo( wp_parse_url( $url, PHP_URL_PATH ), PATHINFO_EXTENSION ) );
					?>
					<li>
						<a class="scm-doc" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener">
							<span class="scm-doc__type"><?php echo esc_html( $ext ?: __( 'File', 'suburbancm' ) ); ?></span>
							<span class="scm-doc__name"><?php echo esc_html( wp_strip_all_tags( $name ) ); ?></span>
							<span class="scm-doc__action"><?php esc_html_e( 'Download ↓', 'suburbancm' ); ?></span>
						</a>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php else : ?>
			<p class="scm-docs__empty"><?php esc_html_e( 'Documents will be posted here.', 'suburbancm' ); ?></p>
		<?php endif; ?>
	</div>
</section>
