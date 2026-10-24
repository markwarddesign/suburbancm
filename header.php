<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <!-- Favicon -->
<link rel="icon" type="image/png" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicon-96x96.png" sizes="96x96" />
<link rel="icon" type="image/svg+xml" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicon.svg" />
<link rel="shortcut icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/favicon.ico" />
<link rel="apple-touch-icon" sizes="180x180" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/apple-touch-icon.png" />
<link rel="manifest" href="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/site.webmanifest" />
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'scm' ); ?>>

<?php do_action( 'tailpress_site_before' ); ?>

<a class="screen-reader-text" href="#site-content"><?php esc_html_e( 'Skip to content', 'suburbancm' ); ?></a>

<?php if ( is_front_page() ) : ?>
    <a class="scm-strip" href="#award">
        <strong>#1</strong>
        <span><?php esc_html_e( 'Fastest-growing business in Idaho', 'suburbancm' ); ?></span><span class="scm-strip__extra"> — <?php esc_html_e( 'BoiseDev Peak 43, 2026', 'suburbancm' ); ?></span>
        <span aria-hidden="true">→</span>
    </a>
<?php endif; ?>

<header class="scm-header">
    <div class="scm-wrap scm-header__inner">
        <a class="scm-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ', ' . __( 'home', 'suburbancm' ) ); ?>">
            <?php suburbancm_logo(); ?>
        </a>

        <nav class="scm-nav" aria-label="<?php esc_attr_e( 'Primary', 'suburbancm' ); ?>">
            <?php suburbancm_flat_menu( 'primary-menu', 'primary' ); ?>
        </nav>

        <button type="button" class="scm-menu-btn" aria-expanded="false" aria-controls="scm-menu" data-scm-menu-open>
            <?php esc_html_e( 'Menu', 'suburbancm' ); ?>
            <svg aria-hidden="true" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M2 5h16M2 10h16M2 15h16"/></svg>
        </button>
    </div>
</header>

<div id="scm-menu" class="scm-menu" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Site menu', 'suburbancm' ); ?>" inert>
    <div class="scm-menu__top">
        <a class="scm-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ', ' . __( 'home', 'suburbancm' ) ); ?>">
            <?php suburbancm_logo(); ?>
        </a>
        <button type="button" class="scm-menu__close" data-scm-menu-close>
            <?php esc_html_e( 'Close', 'suburbancm' ); ?>
            <svg aria-hidden="true" width="18" height="18" viewBox="0 0 18 18" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M3 3l12 12M15 3L3 15"/></svg>
        </button>
    </div>
    <nav class="scm-menu__nav" aria-label="<?php esc_attr_e( 'Mobile', 'suburbancm' ); ?>">
        <?php suburbancm_flat_menu( 'primary-menu', 'primary' ); ?>
    </nav>
    <div class="scm-menu__foot">
        <a class="scm-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Request a consultation', 'suburbancm' ); ?></a>
        <div class="scm-menu__links">
            <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact', 'suburbancm' ); ?></a>
            <a href="<?php echo esc_url( home_url( '/safety-report/' ) ); ?>"><?php esc_html_e( 'Safety report', 'suburbancm' ); ?></a>
            <a href="<?php echo esc_url( SUBURBANCM_CLIENT_LOGIN_URL ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Client login ↗', 'suburbancm' ); ?></a>
        </div>
        <p class="scm-menu__note"><?php esc_html_e( 'Twin Falls, Idaho', 'suburbancm' ); ?></p>
        <p class="scm-menu__award"><?php esc_html_e( '#1 Fastest-growing business in Idaho · Peak 43, 2026', 'suburbancm' ); ?></p>
    </div>
</div>