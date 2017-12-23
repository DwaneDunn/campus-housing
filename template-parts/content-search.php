<?php
/**
 * Template part for displaying results in search pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Campus_Housing
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php if ( has_post_thumbnail() ) { ?>
        <figure class="featured-image index-image">
            <a href="<?php esc_url( get_permalink() ) ?>" rel="bookmark">
				<?php the_post_thumbnail( 'campus_housing-index-img' ); ?>
            </a>
        </figure> <!-- .featured-image .index-image -->
	<?php }  ?>

    <div class="post__content">
        <header class="entry-header">
            <?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

            <?php if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
                <?php campus_housing_posted_on(); ?>
            </div><!-- .entry-meta -->
            <?php endif; ?>
        </header><!-- .entry-header -->

        <div class="entry-summary">
            <?php
                the_excerpt();

                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'campus-housing' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div><!-- .entry-summary -->

        <footer class="entry-footer">
            <?php campus_housing_entry_footer(); ?>
        </footer><!-- .entry-footer -->

    </div> <!-- .post__content -->
</article><!-- #post-<?php the_ID(); ?> -->
