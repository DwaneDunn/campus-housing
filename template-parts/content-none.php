<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Campus_Housing
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<h1 class="page-title"><?php esc_html_e( 'Nothing Found', 'campus-housing' ); ?></h1>
	</header><!-- .page-header -->

	<div class="page-content">
		<?php
		if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

			<p><?php
				printf(
					wp_kses(
						/* translators: 1: link to WP admin new post page. */
						__( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'campus-housing' ),
						array(
							'a' => array(
								'href' => array(),
							),
						)
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
			?></p>

		<?php elseif ( is_search() ) : ?>

			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'campus-housing' ); ?></p>
			<?php
				get_search_form();

		else : ?>

			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'campus-housing' ); ?></p>
			<?php
				get_search_form();

		endif; ?>
	</div><!-- .page-content -->
    <div>
	    <?php
	    if ( is_404() || is_search() ) {
		    ?>
            <h2 class="page-title secondary-title"><?php esc_html_e( '6 Most recent posts:', 'humescores' ); ?></h2>
		    <?php
		    // Get the 6 latest posts
		    $args = array(
			    'posts_per_page' => 6
		    );
		    $latest_posts_query = new WP_Query( $args );
		    // The Loop
		    if ( $latest_posts_query->have_posts() ) {
			    while ( $latest_posts_query->have_posts() ) {
				    $latest_posts_query->the_post();
				    // Get the standard index page content
				    get_template_part( 'template-parts/content', get_post_format() );
			    }
		    }
		    /* Restore original Post Data */
		    wp_reset_postdata();
	    } // endif
	    ?>
    </div>


</section><!-- .no-results -->
