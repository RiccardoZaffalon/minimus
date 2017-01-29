<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package minimus
 */

if ( ! function_exists( 'minimus_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function minimus_posted_on() {
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
		esc_html_x( 'Posted on %s', 'post date', 'minimus' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$posted_on_simple = $time_string;

	$mycontent = get_the_content(); // wordpress users only
	$word = str_word_count(strip_tags($mycontent));
	$m = floor($word / 200);
	$est = ($m<1 ? '< 1 min' : $m . ' min') ;

	echo '<span class="posted-on">' . $posted_on_simple . '</span>'; // WPCS: XSS OK.
	echo '<span class="read-time u-pull-right muted" title="Estimated reading time">' . $est . '</span>'; // WPCS: XSS OK.

}
endif;

if ( ! function_exists( 'minimus_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function minimus_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {

		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'minimus' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<div class="byline"> ' . $byline . '</div>';
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'minimus' ) );
		if ( $categories_list && minimus_categorized_blog() ) {
			if (count (get_the_category()) > 1 || get_the_category()[0]->slug != 'uncategorized') :
				printf( '<div class="cat-links">' . esc_html__( 'Posted in %1$s', 'minimus' ) . '</div>', $categories_list ); // WPCS: XSS OK.
			endif;
		}

		/* translators: used between list items, there is a space after the comma */
		$books_list = get_the_term_list(get_the_ID(), 'books', null,  esc_html__( ', ', 'minimus' ) );
		if ( $books_list && minimus_categorized_blog() ) {
			printf( '<div class="book-links">' . esc_html__( 'Part of %1$s', 'minimus' ) . '</div>', $books_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'minimus' ) );
		if ( $tags_list ) {
			printf( '<div class="tags-links">' . esc_html__( 'Tagged %1$s', 'minimus' ) . '</div>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<div class="comments-link">';
		/* translators: %s: post title */
		/* translators: 1: Number of comments 2: post title */
		$id = get_the_ID();
	    $title = get_the_title();
	    $number = get_comments_number( $id );
        $more = _n( '%1$s Thought<span class="screen-reader-text"> on %2$s</span>', '%1$s Thoughts<span class="screen-reader-text"> on %2$s</span>', $number );
        $more = sprintf( $more, number_format_i18n( $number ), $title );
		comments_popup_link( sprintf( wp_kses( __( 'Thoughts?<span class="screen-reader-text"> on %s</span>', 'minimus' ), array( 'span' => array( 'class' => array('') ) ) ), get_the_title() ), $more, $more );
		echo '</div>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'minimus' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<div class="edit-link">',
		'</div>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function minimus_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'minimus_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'minimus_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so minimus_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so minimus_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in minimus_categorized_blog.
 */
function minimus_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'minimus_categories' );
}
add_action( 'edit_category', 'minimus_category_transient_flusher' );
add_action( 'save_post',     'minimus_category_transient_flusher' );
