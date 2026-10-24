<?php
/**
 * Site footer.
 *
 * Home gets the large "Let's build." statement; every other page gets the gold
 * call-to-action band (the suburbancm/cta-1 block) above the same footer.
 */

$footer_links = [
    [
        'label'    => __( 'Client login ↗', 'suburbancm' ),
        'url'      => SUBURBANCM_CLIENT_LOGIN_URL,
        'class'    => 'scm-client-login',
        'external' => true,
    ],
];

// Templates that end in their own call to action switch this off with the suburbancm_footer_cta filter.
if ( apply_filters( 'suburbancm_footer_cta', ! is_front_page() ) ) {
    echo do_blocks( '<!-- wp:suburbancm/cta-1 {"buttonText":"Request a consultation →","buttonUrl":"/contact/","align":"full"} /-->' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
}
?>

<footer class="scm-footer">
    <div class="scm-wrap scm-footer__inner">

        <?php if ( is_front_page() ) : ?>
            <div class="scm-footer__statement">
                <p class="scm-d scm-statement"><?php esc_html_e( "Let's build.", 'suburbancm' ); ?></p>
                <div class="scm-footer__cta">
                    <p><?php esc_html_e( 'Have a project in mind? Our team will walk you through it.', 'suburbancm' ); ?></p>
                    <div class="scm-btns">
                        <a class="scm-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Request a consultation', 'suburbancm' ); ?></a>
                        <a class="scm-btn scm-btn--line" href="<?php echo esc_url( home_url( '/services/' ) ); ?>"><?php esc_html_e( 'Explore services', 'suburbancm' ); ?></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="scm-footer__top">
            <div class="scm-footer__brand">
                <a class="scm-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) . ', ' . __( 'home', 'suburbancm' ) ); ?>">
                    <?php suburbancm_logo(); ?>
                </a>
                <p><?php esc_html_e( 'Locally owned general contracting and construction management, based in Twin Falls, Idaho.', 'suburbancm' ); ?></p>
                <a class="scm-footer__contact" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact us →', 'suburbancm' ); ?></a>
            </div>
            <nav class="scm-footer__nav" aria-label="<?php esc_attr_e( 'Footer', 'suburbancm' ); ?>">
                <?php suburbancm_flat_menu( 'footer-menu', 'footer', $footer_links ); ?>
            </nav>
        </div>

        <div class="scm-footer__bar">
            <span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> SuburbanCM · <?php esc_html_e( 'General Contracting & Construction Management', 'suburbancm' ); ?></span>
            <strong><?php esc_html_e( '#1 Fastest-growing business in Idaho · Peak 43, 2026', 'suburbancm' ); ?></strong>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>
