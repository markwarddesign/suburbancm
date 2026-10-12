<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
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

<body <?php body_class( 'bg-[#1f1f1f] text-[#e4d198] antialiased' ); ?>>

<?php do_action( 'tailpress_site_before' ); ?>

<header>
    <nav id="main-nav" class="bg-[#2a2a2a] shadow-black-70 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">

            <div class="flex-shrink-0">
                <?php if ( has_custom_logo() ) : ?>
                    <?php the_custom_logo(); ?>
                <?php else : ?>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="text-xl font-bold text-[#e4d198]">
                        <?php bloginfo( 'name' ); ?>
                    </a>
                <?php endif; ?>
            </div>

                <div class="hidden md:flex items-center space-x-1 lg:space-x-4 h-full">
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location'  => 'primary-menu',
                            'container'       => false,
                            'menu_class'      => 'flex space-x-4 h-full items-center',
                            'fallback_cb'     => false,
                            'depth'           => 2,
                            'walker'          => new Suburban_Walker_Nav_Menu(),
                        )
                    );
                    ?>
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-open-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-[#e4d198] hover:text-[#ffffff] hover:bg-[#444444] focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#a38f50]" aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>

                <!-- Mobile Menu -->
                <div id="mobile-menu" class="hidden bg-[#2a2a2a]">
                    <button id="mobile-menu-close-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-[#e4d198] hover:text-[#ffffff] hover:bg-[#444444] focus:outline-none focus:ring-2 focus:ring-inset focus:ring-[#a38f50]">
                        <span class="sr-only">Close menu</span>
                        <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <nav class="mt-4">
                        <?php
                        wp_nav_menu(
                            array(
                                'theme_location' => 'primary-menu',
                                'container'      => false,
                                'menu_class'     => 'space-y-10',
                                'fallback_cb'    => false,
                                'depth'          => 1,
                            )
                        );
                        ?>
                    </nav>
                </div>

            </div>
        </div>
    </nav>
</header>