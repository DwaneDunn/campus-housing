<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Campus_Housing
 */

?>

	</div> <!-- #content -->

    <?php get_sidebar( 'footer' ); ?>

	<footer id="colophon" class="site-footer" role="contentinfo">

        <div class="site-footer__wrap">

            <?php
                // Display only if there is a Footer Social Menu
                if ( has_nav_menu( 'footer-menu-social' ) ) { ?>
                <nav class="social-menu">
                    <?php
                        wp_nav_menu( array(

                            'theme_location'    => 'footer-menu-social',
                            'menu_class'        => 'social-links-menu',
                            'depth'             => 1,
                        // 'link_before'       => '<span class="screen-reader-text">',
                        // 'link_after'        => '</span>',
                        ) );
                    ?>
                </nav> <!-- .social-menu -->
            <?php } ?>

            <div class="site-info">
                <div>
                    <a href="<?php echo esc_url( __( 'https://wordpress.org/', 'campus-housing' ) ); ?>"> <?php printf( esc_html__( 'Proudly powered by %s', 'campus-housing' ), 'WordPress' ); ?>
                    </a>
                </div>

                <div>
                    <?php
                        printf( esc_html__( 'Theme: %1$s by %2$s.', 'campus-housing' ), 'campus-housing', '<a href="https://dwanedunn.com" rel="designer" >Dwane Dunn</a>' );
                    ?>
                </div>

            </div> <!-- .site-info -->
        </div> <!-- .site-footer__wrap -->
	</footer><!-- #colophon -->

</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
