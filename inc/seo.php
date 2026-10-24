<?php
/**
 * SEO helpers. Yoast SEO owns the head; this file fills its gaps:
 * richer organisation schema, archive titles, fallback meta descriptions,
 * image alt fallbacks and lighter font loading.
 *
 * @package suburbancm
 */

/**
 * Who the business is, as structured data. No street address or phone: the site
 * keeps contact on the Contact page, and the Google Business Profile carries NAP.
 */
function suburbancm_business_schema() {
	return apply_filters(
		'suburbancm_business_schema',
		[
			'@type'       => [ 'Organization', 'GeneralContractor' ],
			'description' => __( 'Commercial general contractor and construction manager in Twin Falls, Idaho, delivering public, healthcare, commercial and industrial projects across the Magic Valley and southern Idaho.', 'suburbancm' ),
			'slogan'      => __( 'Building your vision. Managing every detail.', 'suburbancm' ),
			'address'     => [
				'@type'           => 'PostalAddress',
				'addressLocality' => 'Twin Falls',
				'addressRegion'   => 'ID',
				'addressCountry'  => 'US',
			],
			'areaServed'  => [
				[ '@type' => 'City', 'name' => 'Twin Falls, Idaho' ],
				[ '@type' => 'Place', 'name' => 'Magic Valley, Idaho' ],
				[ '@type' => 'State', 'name' => 'Idaho' ],
			],
			'knowsAbout'  => [
				'Construction management',
				'General contracting',
				'Pre-construction services',
				'Design-build',
				'Public works construction',
				'Commercial construction',
			],
			'award'       => __( '#1 Fastest-Growing Business in Idaho — BoiseDev Peak 43, 2026', 'suburbancm' ),
			'priceRange'  => '$$$',
		]
	);
}

/**
 * Merge the business details into Yoast's Organization node rather than adding a second one.
 *
 * @param array $data Yoast organisation schema.
 * @return array
 */
function suburbancm_yoast_organization( $data ) {
	return array_merge( $data, suburbancm_business_schema() );
}
add_filter( 'wpseo_schema_organization', 'suburbancm_yoast_organization' );

/**
 * Without Yoast, print the organisation on the front page so the schema doesn't vanish.
 */
function suburbancm_fallback_schema() {
	if ( defined( 'WPSEO_VERSION' ) || ! is_front_page() ) {
		return;
	}
	$data = array_merge(
		[
			'@context' => 'https://schema.org',
			'name'     => get_bloginfo( 'name' ),
			'url'      => home_url( '/' ),
		],
		suburbancm_business_schema()
	);
	printf( '<script type="application/ld+json">%s</script>' . "\n", wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) );
}
add_action( 'wp_head', 'suburbancm_fallback_schema' );

/**
 * Titles and descriptions for the listing pages, which have no editor screen of their own.
 * Each entry is [ title, description ]; null means leave Yoast's value alone.
 *
 * @return array{0:?string,1:?string}
 */
function suburbancm_archive_seo() {
	// The short name keeps titles under ~60 characters, where Google cuts them off.
	$brand = apply_filters( 'suburbancm_seo_brand', 'SuburbanCM' );

	if ( is_post_type_archive( 'projects' ) ) {
		return [
			/* translators: %s: site name */
			sprintf( __( 'Construction Projects in Southern Idaho | %s', 'suburbancm' ), $brand ),
			__( 'Public works, healthcare, park and commercial projects delivered by SuburbanCM across the Magic Valley — see the scope, schedule and results of each build.', 'suburbancm' ),
		];
	}
	if ( is_post_type_archive( 'team' ) ) {
		return [
			/* translators: %s: site name */
			sprintf( __( 'Our Team | %s', 'suburbancm' ), $brand ),
			__( 'Meet the construction managers and builders behind SuburbanCM, the Twin Falls general contractor ranked #1 on BoiseDev’s Peak 43 for 2026.', 'suburbancm' ),
		];
	}
	if ( is_post_type_archive( 'bidding' ) ) {
		return [
			/* translators: %s: site name */
			sprintf( __( 'Subcontractor Bid Opportunities | %s', 'suburbancm' ), $brand ),
			__( 'Open bid packages from SuburbanCM in Twin Falls, Idaho. Review scopes, download plans and specs, and submit your bid for current projects.', 'suburbancm' ),
		];
	}
	if ( is_tax( 'project_type' ) || is_tax( 'services' ) ) {
		$term = get_queried_object();

		// The service terms double as the service pages, so they target the service search.
		$services = [
			'construction-management' => [
				__( 'Construction Manager in Twin Falls, Idaho', 'suburbancm' ),
				__( 'Licensed Idaho construction managers for cities, agencies and private owners. CM/GC and CM-at-risk delivery from budget to closeout.', 'suburbancm' ),
			],
			'general-contracting'     => [
				__( 'Commercial General Contractor, Twin Falls ID', 'suburbancm' ),
				__( 'Licensed Idaho public works and commercial general contractor. Bid and negotiated work across the Magic Valley, delivered on time and on budget.', 'suburbancm' ),
			],
			'pre-construction'        => [
				__( 'Pre-Construction Services in Idaho', 'suburbancm' ),
				__( 'Budgets, feasibility, constructability reviews and scheduling before you break ground, so your Idaho project starts with fewer surprises.', 'suburbancm' ),
			],
		];
		if ( is_tax( 'services' ) && isset( $services[ $term->slug ] ) ) {
			return [ $services[ $term->slug ][0] . ' | ' . $brand, $services[ $term->slug ][1] ];
		}

		$desc = $term->description ? wp_strip_all_tags( $term->description ) : sprintf(
			/* translators: %s: project type or service, lower case */
			__( '%s projects delivered by SuburbanCM, a general contractor and construction manager based in Twin Falls, Idaho.', 'suburbancm' ),
			$term->name
		);
		return [
			/* translators: 1: term name, 2: site name */
			sprintf( __( '%1$s Projects in Idaho | %2$s', 'suburbancm' ), $term->name, $brand ),
			wp_trim_words( $desc, 30, '…' ),
		];
	}
	return [ null, null ];
}

/**
 * Archive title, unless an editor has typed one into Yoast.
 *
 * @param string $title Title from Yoast.
 * @return string
 */
function suburbancm_seo_title( $title ) {
	[ $archive_title ] = suburbancm_archive_seo();
	if ( null === $archive_title ) {
		return $title;
	}
	if ( is_tax() ) {
		$custom = class_exists( 'WPSEO_Taxonomy_Meta' ) ? WPSEO_Taxonomy_Meta::get_meta_without_term( 'title' ) : '';
		if ( $custom ) {
			return $title;
		}
	}
	return $archive_title;
}
add_filter( 'wpseo_title', 'suburbancm_seo_title' );
add_filter( 'wpseo_opengraph_title', 'suburbancm_seo_title' );

/**
 * Meta description fallback: archives get a written line, projects and team members
 * borrow their own text. Anything typed into Yoast wins.
 *
 * @param string $description Description from Yoast.
 * @return string
 */
function suburbancm_seo_description( $description ) {
	if ( $description ) {
		return $description;
	}
	[ , $archive_description ] = suburbancm_archive_seo();
	if ( null !== $archive_description ) {
		return $archive_description;
	}
	if ( is_singular( [ 'projects', 'team', 'bidding', 'post' ] ) ) {
		$post = get_queried_object();
		$text = has_excerpt( $post ) ? $post->post_excerpt : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );
		$text = trim( preg_replace( '/\s+/', ' ', $text ) );
		if ( $text ) {
			return wp_html_excerpt( $text, 155, '…' );
		}
		if ( is_singular( 'projects' ) ) {
			/* translators: %s: project name */
			return sprintf( __( '%s — a SuburbanCM project in southern Idaho. See the scope, schedule and photos.', 'suburbancm' ), get_the_title( $post ) );
		}
	}
	return $description;
}
add_filter( 'wpseo_metadesc', 'suburbancm_seo_description' );
add_filter( 'wpseo_opengraph_desc', 'suburbancm_seo_description' );

/**
 * Alt text for an attachment, falling back to a description of where it sits.
 *
 * @param int    $attachment_id Attachment ID.
 * @param string $fallback      Text to use when the media library has no alt.
 * @return string
 */
function suburbancm_image_alt( $attachment_id, $fallback ) {
	$alt = trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) );
	return '' !== $alt ? $alt : $fallback;
}

/**
 * Photos dropped into a project's content without alt text get the project name,
 * so galleries aren't a row of blank images to search engines and screen readers.
 *
 * @param string $block_content Rendered block.
 * @param array  $block         Parsed block.
 * @return string
 */
function suburbancm_project_image_alts( $block_content, $block ) {
	if ( ! is_singular( 'projects' ) || ! in_array( $block['blockName'], [ 'core/image', 'core/gallery' ], true ) ) {
		return $block_content;
	}
	static $n = 0;
	$tags = new WP_HTML_Tag_Processor( $block_content );
	while ( $tags->next_tag( 'img' ) ) {
		if ( '' === trim( (string) $tags->get_attribute( 'alt' ) ) ) {
			$n++;
			/* translators: 1: project name, 2: photo number */
			$tags->set_attribute( 'alt', sprintf( __( '%1$s, photo %2$d', 'suburbancm' ), get_the_title(), $n ) );
		}
	}
	return $tags->get_updated_html();
}
add_filter( 'render_block', 'suburbancm_project_image_alts', 10, 2 );

/**
 * Load the web fonts as their own stylesheet (with a preconnect) instead of an @import
 * inside style.css, which made the browser wait for one file before finding the next.
 */
function suburbancm_enqueue_fonts() {
	wp_enqueue_style(
		'suburbancm-fonts',
		'https://fonts.googleapis.com/css2?family=Archivo:wdth,wght@62..125,400..900&family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap',
		[],
		null
	);
}
add_action( 'wp_enqueue_scripts', 'suburbancm_enqueue_fonts', 5 );

/**
 * @param array  $urls          Resource hints.
 * @param string $relation_type Hint type.
 * @return array
 */
function suburbancm_font_hints( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = [ 'href' => 'https://fonts.gstatic.com', 'crossorigin' => 'anonymous' ];
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'suburbancm_font_hints', 10, 2 );

/**
 * Old URLs that other sites still link to, sent to where that content lives now.
 *
 * @return array<string,string> Path => destination path.
 */
function suburbancm_legacy_redirects() {
	return apply_filters(
		'suburbancm_legacy_redirects',
		[
			// Linked from the City of Twin Falls bid page (tfid.org, bid 144).
			'cotf-pw-site' => '/projects/city-of-twin-falls-public-works-site-improvements/',
		]
	);
}

/**
 * 301 a legacy path, but only when WordPress would otherwise 404 — real pages always win.
 */
function suburbancm_redirect_legacy_urls() {
	if ( ! is_404() ) {
		return;
	}
	$path      = trim( (string) wp_parse_url( $_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH ), '/' ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	$redirects = suburbancm_legacy_redirects();
	if ( isset( $redirects[ $path ] ) ) {
		wp_safe_redirect( home_url( $redirects[ $path ] ), 301, 'SuburbanCM' );
		exit;
	}
}
add_action( 'template_redirect', 'suburbancm_redirect_legacy_urls' );
