<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Minimus
 */

if ( ! function_exists( 'minimus_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function minimus_paging_nav($arrows = true, $ends = true, $pages = 2) {
    if (is_singular()) return;

    global $wp_query, $paged;
    $pagination = '';

    $max_page = $wp_query->max_num_pages;
    if ($max_page == 1) return;
    if (empty($paged)) $paged = 1;

    if ($arrows) $pagination .= minimus_pagination_link($paged - 1, 'arrow' . (($paged <= 1) ? ' unavailable' : ''), '&laquo;', 'Previous Page');
    if ($ends && $paged > $pages + 1) $pagination .= minimus_pagination_link(1);
    if ($ends && $paged > $pages + 2) $pagination .= minimus_pagination_link(1, 'unavailable', '&hellip;');
    for ($i = $paged - $pages; $i <= $paged + $pages; $i++) {
        if ($i > 0 && $i <= $max_page)
            $pagination .= minimus_pagination_link($i, ($i == $paged) ? 'current' : '');
    }
    if ($ends && $paged < $max_page - $pages - 1) $pagination .= minimus_pagination_link($max_page, 'unavailable', '&hellip;');
    if ($ends && $paged < $max_page - $pages) $pagination .= minimus_pagination_link($max_page);

    if ($arrows) $pagination .= minimus_pagination_link($paged + 1, 'arrow' . (($paged >= $max_page) ? ' unavailable' : ''), '&raquo;', 'Next Page');

    $pagination = '<ul class="pagination">' . $pagination . '</ul>';

    echo $pagination;
}
endif;

if ( ! function_exists( 'minimus_pagination_link' ) ) :
function minimus_pagination_link($page, $class = '', $content = '', $title = '') {
    $id = sanitize_title_with_dashes('pagination-page-' . $page . ' ' . $class);
    $href = (strrpos($class, 'unavailable') === false && strrpos($class, 'current') === false) ? get_pagenum_link($page) : "#$id";

    $class = empty($class) ? $class : " class=\"$class\"";
    $content = !empty($content) ? $content : $page;
    $title = !empty($title) ? $title : 'Page ' . $page;

    return "<li$class><a id=\"$id\" href=\"$href\" title=\"$title\">$content</a></li>\n";
}
endif;

if ( ! function_exists( 'minimus_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 */
function minimus_paging_nav() {
	// Don't print empty markup if there's only one page.
	if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
		return;
	}
	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'minimus' ); ?></h1>
		<div class="nav-links">

			<?php if ( get_next_posts_link() ) : ?>
			<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'minimus' ) ); ?></div>
			<?php endif; ?>

			<?php if ( get_previous_posts_link() ) : ?>
			<div class="nav-next"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'minimus' ) ); ?></div>
			<?php endif; ?>

		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'minimus_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 */
function minimus_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'minimus' ); ?></h1>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'minimus' ) );
				next_post_link(     '<div class="nav-next">%link</div>',     _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link',     'minimus' ) );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

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
		_x( 'Posted on %s', 'post date', 'minimus' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		_x( 'by %s', 'post author', 'minimus' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

}
endif;

if ( ! function_exists( 'minimus_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function minimus_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'minimus' ) );
		if ( $categories_list && minimus_categorized_blog() ) {
			printf( '<span class="cat-links">' . __( 'Posted in %1$s', 'minimus' ) . '</span>', $categories_list );
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'minimus' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . __( 'Tagged %1$s', 'minimus' ) . '</span>', $tags_list );
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'minimus' ), __( '1 Comment', 'minimus' ), __( '% Comments', 'minimus' ) );
		echo '</span>';
	}

	edit_post_link( __( 'Edit', 'minimus' ), '<span class="edit-link">', '</span>' );
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
	// Like, beat it. Dig?
	delete_transient( 'minimus_categories' );
}
add_action( 'edit_category', 'minimus_category_transient_flusher' );
add_action( 'save_post',     'minimus_category_transient_flusher' );
