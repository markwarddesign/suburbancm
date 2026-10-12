<?php
// filepath: /Users/kramdraw85/Local Sites/suburban-cm/app/public/wp-content/themes/suburban/page.php

get_header(); // Load the header template
?>

<main id="site-content" role="main">
    <?php
    // Start the Loop
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();

            // Output the block content
            the_content();

        endwhile;
    endif;
    ?>
</main>

<?php
get_footer(); // Load the footer template