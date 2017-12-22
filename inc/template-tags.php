<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Campus_Housing
 */

if ( ! function_exists( 'campus_housing_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function campus_housing_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( 'c' ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Published on %s', 'post date', 'campus-housing' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'Written by %s', 'post author', 'campus-housing' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span> <span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

    // Show Number of Comments
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo ' <span class="comments-link"><span class="extra">Discussion </span>';
			comments_popup_link(
				sprintf(
					wp_kses(
					/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'campus-housing' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

    // Edit Comments
		edit_post_link(
			sprintf(
				wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
					__( ' Edit <span class="screen-reader-text">%s</span>', 'campus-housing' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			'<span class="edit-link"><span class="extra">Admin</span>',
			'</span>'
		);

	}
endif;

if ( ! function_exists( 'campus_housing_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function campus_housing_entry_footer() {
		// Hide tag text for pages.
		if ( 'post' === get_post_type() ) {

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'campus-housing' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'campus-housing' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

	}
endif;

/** Display category list **/
function campus_housing_the_category_list() {

	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( esc_html__( ', ', 'campus-housing' ) );
	if ( $categories_list ) {
		/* translators: 1: list of categories. */
		printf( '<span class="cat-links">' . esc_html__( 'Categories: %1$s', 'campus-housing' ) . '</span>', $categories_list ); // WPCS: XSS OK.
	}
}

if ( ! function_exists( 'campus_housing_post_thumbnail' ) ) :
/**
 * Displays an optional post thumbnail.
 *
 * Wraps the post thumbnail in an anchor element on index views, or a div
 * element when on single views.
 */
function campus_housing_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) :
	?>

	<div class="post-thumbnail">
		<?php the_post_thumbnail(); ?>
	</div><!-- .post-thumbnail -->

	<?php else : ?>

	<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
		<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
		?>
	</a>

	<?php endif; // End is_singular().
}
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function campus_housing_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'campus_housing_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'campus_housing_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so campus_housing_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so campus_housing_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in campus_housing_categorized_blog.
 */
function campus_housing_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'campus_housing_categories' );
}
add_action( 'edit_category', 'campus_housing_category_transient_flusher' );
add_action( 'save_post',     'campus_housing_category_transient_flusher' );


/**
 * Post navigation (previous / next post) for single posts.
 */
function campus_housing_post_navigation() {
	the_post_navigation( array(
		'next_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Next', 'campus_housing' ) . '</span> ' .
		               '<span class="screen-reader-text">' . __( 'Next post:', 'campus_housing' ) . '</span> ' .
		               '<span class="post-title">%title</span>',
		'prev_text' => '<span class="meta-nav" aria-hidden="true">' . __( 'Previous', 'campus_housing' ) . '</span> ' .
		               '<span class="screen-reader-text">' . __( 'Previous post:', 'campus_housing' ) . '</span> ' .
		               '<span class="post-title">%title</span>',
	) );
}