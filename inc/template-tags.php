<?php
/**
 * Template helpers shared by the project, team and bidding templates.
 *
 * @package suburbancm
 */

/**
 * Read a custom field through ACF when it's active, otherwise straight from post meta.
 *
 * @param string   $name    Field name.
 * @param int|null $post_id Post ID (defaults to the current post).
 * @return mixed
 */
function suburbancm_field( $name, $post_id = null ) {
	$post_id = $post_id ?: get_the_ID();
	if ( function_exists( 'get_field' ) ) {
		return get_field( $name, $post_id );
	}
	return get_post_meta( $post_id, $name, true );
}

/**
 * Format a stored date (Y-m-d, Ymd or anything strtotime reads) for display.
 *
 * @param string $date   Stored date.
 * @param string $format Output format.
 * @return string Empty when the date can't be read.
 */
function suburbancm_date( $date, $format = 'M j, Y' ) {
	if ( ! $date ) {
		return '';
	}
	$timestamp = strtotime( (string) $date );
	return $timestamp ? date_i18n( $format, $timestamp ) : '';
}

/**
 * Project facts from the Project Page block's settings, falling back to the project meta fields.
 *
 * @param int $post_id Project ID.
 * @return array client, location, size, start, completion, summary, subtitle.
 */
function suburbancm_project_info( $post_id ) {
	$attrs = [];
	foreach ( parse_blocks( get_post_field( 'post_content', $post_id ) ) as $block ) {
		if ( 'suburbancm/project-page' === $block['blockName'] ) {
			$attrs = $block['attrs'];
			break;
		}
	}
	$meta = static fn( $key ) => get_post_meta( $post_id, '_wp_projects_' . $key, true );

	return [
		'client'     => $attrs['client'] ?? '' ?: $meta( 'client' ),
		'location'   => $attrs['location'] ?? '' ?: $meta( 'location' ),
		'size'       => $attrs['size'] ?? '' ?: $meta( 'size' ),
		'start'      => $attrs['startDate'] ?? '' ?: $meta( 'start_date' ),
		'completion' => $attrs['completionDate'] ?? '' ?: $meta( 'completion_date' ),
		'summary'    => $attrs['shortDescription'] ?? '' ?: $meta( 'short_description' ),
		'subtitle'   => $meta( 'subtitle' ),
	];
}

/**
 * First term name of a taxonomy for a post, or ''.
 *
 * @param int    $post_id  Post ID.
 * @param string $taxonomy Taxonomy.
 * @return string
 */
function suburbancm_first_term( $post_id, $taxonomy ) {
	$terms = get_the_terms( $post_id, $taxonomy );
	return ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : '';
}

/**
 * One short line for a project card: client · location · size · completed.
 *
 * @param int $post_id Project ID.
 * @return string
 */
function suburbancm_project_meta_line( $post_id ) {
	$info  = suburbancm_project_info( $post_id );
	$parts = array_filter(
		[
			wp_strip_all_tags( (string) $info['client'] ),
			wp_strip_all_tags( (string) $info['location'] ),
			wp_strip_all_tags( (string) $info['size'] ),
			$info['completion'] ? sprintf(
				/* translators: %s: completion month and year */
				__( 'Completed %s', 'suburbancm' ),
				suburbancm_date( $info['completion'], 'F Y' )
			) : '',
		]
	);
	return implode( ' · ', $parts );
}

/**
 * Print a project photo card.
 *
 * @param int    $post_id Project ID.
 * @param string $variant 'feature' (full width) or 'card'.
 */
function suburbancm_project_card( $post_id, $variant = 'card' ) {
	$type = suburbancm_first_term( $post_id, 'project_type' );
	$meta = suburbancm_project_meta_line( $post_id );
	?>
	<a class="scm-card scm-card--<?php echo esc_attr( $variant ); ?>" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
		<span class="scm-card__pic">
			<?php
			if ( has_post_thumbnail( $post_id ) ) {
				echo get_the_post_thumbnail( $post_id, 'feature' === $variant ? 'full' : 'large', [ 'alt' => '', 'loading' => 'lazy' ] );
			}
			?>
		</span>
		<span class="scm-card__body">
			<span class="scm-card__head">
				<?php if ( $type ) : ?>
					<span class="scm-eyebrow scm-gold"><?php echo esc_html( $type ); ?></span>
				<?php endif; ?>
				<span class="scm-d scm-card__title"><?php echo esc_html( get_the_title( $post_id ) ); ?></span>
			</span>
			<?php if ( $meta ) : ?>
				<span class="scm-card__meta"><?php echo esc_html( $meta ); ?></span>
			<?php endif; ?>
		</span>
	</a>
	<?php
}

/**
 * Print the Page Title block from a template.
 *
 * @param array $attrs suburbancm/page-title attributes.
 */
function suburbancm_page_header( array $attrs ) {
	echo render_block( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- block output.
		[
			'blockName'    => 'suburbancm/page-title',
			'attrs'        => $attrs + [ 'align' => 'full' ],
			'innerBlocks'  => [],
			'innerHTML'    => '',
			'innerContent' => [],
		]
	);
}

/**
 * Where a bid is submitted: its custom URL, or an email to the estimating inbox.
 *
 * @param int $post_id Bid ID.
 * @return array url, external.
 */
function suburbancm_bid_submit( $post_id ) {
	$custom = suburbancm_field( 'custom_bid_url', $post_id );
	if ( $custom ) {
		return [ 'url' => $custom, 'external' => true ];
	}
	$email = apply_filters( 'suburbancm_bid_email', 'andrew@suburbancm.com' );
	return [
		'url'      => 'mailto:' . $email . '?subject=' . rawurlencode( 'Bid Submission: ' . get_the_title( $post_id ) ),
		'external' => false,
	];
}

/**
 * ID of the WPForms form used to register subcontractors on the bidding page.
 * Set it with the suburbancm_bidder_form_id filter, or name a form "Bidder Registration".
 *
 * @return int 0 when there's no form.
 */
function suburbancm_bidder_form_id() {
	$id = (int) apply_filters( 'suburbancm_bidder_form_id', 0 );
	if ( $id || ! post_type_exists( 'wpforms' ) ) {
		return $id;
	}
	$forms = get_posts(
		[
			'post_type'      => 'wpforms',
			'title'          => 'Bidder Registration',
			'posts_per_page' => 1,
			'fields'         => 'ids',
		]
	);
	return $forms ? (int) $forms[0] : 0;
}

/**
 * Print the facts bar for a project (client, location, size, dates).
 *
 * @param array $info From suburbancm_project_info().
 */
function suburbancm_project_spec( array $info ) {
	$rows = array_filter(
		[
			__( 'Client', 'suburbancm' )    => wp_strip_all_tags( (string) $info['client'] ),
			__( 'Location', 'suburbancm' )  => wp_strip_all_tags( (string) $info['location'] ),
			__( 'Size', 'suburbancm' )      => wp_strip_all_tags( (string) $info['size'] ),
			__( 'Started', 'suburbancm' )   => suburbancm_date( $info['start'] ),
			__( 'Completed', 'suburbancm' ) => $info['completion'] ? suburbancm_date( $info['completion'] ) : ( $info['start'] ? __( 'In progress', 'suburbancm' ) : '' ),
		]
	);
	if ( ! $rows ) {
		return;
	}
	?>
	<section class="scm-spec">
		<dl class="scm-wrap scm-spec__grid">
			<?php foreach ( $rows as $label => $value ) : ?>
				<div class="scm-spec__item">
					<dt><?php echo esc_html( $label ); ?></dt>
					<dd><?php echo esc_html( $value ); ?></dd>
				</div>
			<?php endforeach; ?>
		</dl>
	</section>
	<?php
}

/**
 * The project after this one (older), wrapping round to the newest.
 *
 * @param int $post_id Current project.
 * @return WP_Post|null
 */
function suburbancm_next_project( $post_id ) {
	$older = get_posts(
		[
			'post_type'      => 'projects',
			'posts_per_page' => 1,
			'date_query'     => [ [ 'before' => get_post_field( 'post_date', $post_id ) ] ],
			'post__not_in'   => [ $post_id ],
		]
	);
	if ( $older ) {
		return $older[0];
	}
	$newest = get_posts( [ 'post_type' => 'projects', 'posts_per_page' => 1, 'post__not_in' => [ $post_id ] ] );
	return $newest ? $newest[0] : null;
}
