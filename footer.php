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

        <!-- Make sure there is a social menu to display.-->
            <?php if ( has_nav_menu( 'social' ) ) { ?>

                <nav class="social-menu">

                    <?php
                    wp_nav_menu( array(

                        'theme_location'    => 'menu-2',
                        'menu_class'        => 'social-links-menu',
                        'depth'             => 1,
                        'link_before'       => '<span class="screen-reader-text">',
                        'link_after'        => '</span>',
                        // 'link_after'        => '</span>' . humescores_get_svg( array( 'icon' => 'chain' ) ),

                    ) );
                    ?>

                </nav> <!-- .social-menu -->

            <?php } ?> <!-- Endif has_nav_menu( 'social' )  -->

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
