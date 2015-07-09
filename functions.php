<?php

add_action( 'after_setup_theme', 'child_theme_setup_before_parent', 0 );
add_action( 'after_setup_theme', 'child_theme_setup1', 11 );
add_action( 'after_setup_theme', 'child_theme_setup2', 14 );

function child_theme_setup_before_parent() {

	if ( ! defined( 'SCRIPT_DEBUG' ) ) {
		define( 'SCRIPT_DEBUG', false );
	}

}

function child_theme_setup1() {

	// Register site styles and scripts
	add_action( 'wp_enqueue_scripts', 'child_theme_register_styles' );

	// Enqueue site styles and scripts
	add_action( 'wp_enqueue_scripts', 'child_theme_enqueue_styles' );

}

function child_theme_setup2() {

	add_filter( 'hybopress_loop_pagination_args', 'child_theme_loop_pagination_args' );
	add_filter( 'hybopress_pagination_classes', 'child_theme_pagination_classes' );

	remove_action( 'hybopress_post_info_comments', 'hybopress_do_post_info_comments' );

	add_action( 'hybopress_post_info_comments', 'child_theme_do_post_info_comments' );


	add_filter( 'hybopress_page_header_title', 'child_theme_page_header_title', 10, 2 );
	add_filter( 'hybopress_page_header_subtitle', 'child_theme_page_header_subtitle', 10, 2 );


	add_filter( 'hybopress_show_author_box', 'child_theme_show_author_box' );
	add_action( 'hybopress_before_content', 'child_theme_do_author_box' );

	add_filter( 'hybopress_use_cache', 'child_theme_use_cache' );
	add_filter( 'hybopress_social_share_title', 'child_theme_social_share_title' );


}

function child_theme_show_author_box( $show ) {
	if ( is_author() ) {
		$show = true;
	}

	return $show;
}

function child_theme_do_author_box() {
	if ( is_author() ) {
		locate_template( array( 'misc/author-box.php' ), true );
	} else if ( is_search() ) {
		locate_template( array( 'misc/search-box.php' ), true );
	}
}

function child_theme_page_header_title( $page_title, $page_title_classes ) {
	global $wp_query;

	if ( is_author() ) {
		$page_title = strip_tags( $page_title );
		$page_title = __( 'Author Archive for: ', 'fold' ) . $page_title;
		$page_title     = sprintf( '<h1 class="%s">%s</h1>', $page_title_classes, $page_title );
	} else if ( ! empty( $wp_query->found_posts ) && is_search() ) {
		$page_title = strip_tags( $page_title );
		$page_title = $wp_query->found_posts ." ". $page_title;
		$page_title     = sprintf( '<h1 class="%s">%s</h1>', $page_title_classes, $page_title );
	}

	return $page_title;
}

function child_theme_page_header_subtitle( $page_subtitle, $page_subtitle_classes ) {

	if ( is_author() || is_search() ) {
		$page_subtitle = '';
	}

	return $page_subtitle;
}



function child_theme_register_styles() {
	$main_styles = trailingslashit( CHILD_THEME_URI ) . "assets/css/child-style.css";

	wp_register_style(
		sanitize_key(  'child-style' ), esc_url( $main_styles ), array( 'skin' ), PARENT_THEME_VERSION, esc_attr( 'all' )
	);
}

function child_theme_enqueue_styles() {
	wp_enqueue_style( 'child-style' );
}

function child_theme_loop_pagination_args( $args ) {
		global $wp_rewrite, $wp_query;

		/* Get the current page. */
		$current = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );
		$pages   = $wp_query->max_num_pages;

		$args['before']   .= '<span class="pagination-meta pull-right">' . sprintf( __( 'Page %d of %d', 'fold' ), $current, $pages ) . '</span>';

		$args['prev_text'] = sprintf( _x( '&larr; %1$s Previous %2$s', 'posts navigation', 'fold' ), '<span class="sr-only">', '</span>' );
		$args['next_text'] = sprintf( _x( '%1$s Next %2$s &rarr;', 'posts navigation', 'fold' ), '<span class="sr-only">', '</span>' );

		return $args;

}

function child_theme_pagination_classes( $pagination_classes ) {

	$pagination_classes .= ' pull-left';

	return $pagination_classes;
}

function child_theme_do_post_info_comments() {

	if ( get_theme_mod( 'disable_comments_meta', 0 ) ) {
		return;
	}

	//comments_popup_link( number_format_i18n( 0 ), number_format_i18n( 1 ), '%', 'comments-link', '' );
	comments_popup_link( false, false, false, 'comments-link' );
}

function child_theme_use_cache( $use_cache ) {
	return false;
}

function child_theme_social_share_title( $share_title ) {

	$share_title = '<h5 class="h4">' . strip_tags( $share_title ) . '</h5>';

	return $share_title;
}
